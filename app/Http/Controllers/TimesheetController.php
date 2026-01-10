<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timesheet;
use App\Models\TimesheetRow;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;


class TimesheetController extends Controller
{
    // ------------------------------
    // STAFF FUNCTIONS
    // ------------------------------

    // Show form to create a timesheet
    public function create()
    {
        return view('timesheet.create');
    }

    // Store a new timesheet manually - Add button (optional)
    public function store(Request $request)
    {
        $userId = auth()->id();

        dd($request->all()); //debug
        $timesheet = Timesheet::create([
            'user_id' => auth()->id(),
            'week'    => $request->week,
            'month'   => $request->month,
            'year'    => $request->year,
            'status'  => $request->action === 'save' ? 'Saved' : 'Submitted',
        ]);

        $startDate = Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();
        $endDate   = Carbon::now()->startOfWeek(Carbon::MONDAY)->addDays(6)->toDateString();

        // Prevent duplicate timesheet for same week
        $exists = Timesheet::where('user_id', $userId)
            ->where('start_date', $startDate)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'Timesheet for this week already exists.');
        }

        // Create timesheet
        Timesheet::create([
            'user_id'    => $userId,
            'week'       => Carbon::now()->weekOfYear,
            'month'      => Carbon::now()->month,
            'year'       => Carbon::now()->year,
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'status'     => 'open',
        ]);

        return redirect()->route('timesheet.index')
            ->with('success', 'Weekly timesheet created.');
    }

    // List all timesheets of currently logged-in staff
    public function index()
{
    // Gets currently logged-in user ID
    $userId = auth()->id();

    // Current week start (Monday) & end (Friday) using Carbon object
    $startDateCarbon = Carbon::now()->startOfWeek(Carbon::MONDAY);

    //Convert carbon object (startDateCarbon) to date string (YYY-MM-DD)
    $startDate = $startDateCarbon->toDateString();

    // Calculate week end date (Friday) - exclude weekend
    $weekEnd   = $startDateCarbon->copy()->addDays(value: 6)->toDateString();

    // Auto-create timesheet for current week if not exists
    $exists = Timesheet::where('user_id', $userId)
        ->where('start_date', $startDate)
        ->exists();

    // Auto create timesheet
    if (!$exists) {
        Timesheet::create([
            'user_id'    => $userId,
            'week'       => $startDateCarbon->weekOfYear,  // week number
            'month'      => \Carbon\Carbon::parse($startDate)->month,       // month of the start date (Monday
            'year'       => $startDateCarbon->year,        // year of the start date (Monday)
            'start_date' => $startDate,
            'end_date'   => $weekEnd,
            'status'     => 'open',
        ]);
    }

    // Fetch all timesheets
    $timesheets = Timesheet::where('user_id', $userId)
        ->orderBy('start_date', 'desc') //in descending order so timesheet latest appear at the top
        ->paginate(10); 

    $currentWeekStart = $startDate;

    return view('timesheet.index', compact('timesheets', 'currentWeekStart'));
}


    // Show single timesheet with its rows (View function)
    public function show($id)
{
    try {
        $decryptedId = Crypt::decrypt($id);
    } catch (DecryptException $e) {
        abort(404);
    }

    // Load timesheet with rows and user
    $timesheet = Timesheet::with(['rows', 'user'])->findOrFail($decryptedId);

    // Group rows by date (this is the variable your Blade uses)
    $groupedRows = $timesheet->rows->groupBy('date');

    // Weekly total of hours
    $weeklyTotal = $timesheet->rows->sum('total_hours');

    // Optional: calculate hours from start_time to  end_time for each row
    $totalMinutes = 0;
    foreach ($timesheet->rows as $row) {
        if ($row->start_time && $row->end_time) {
            $start = Carbon::createFromFormat('H:i:s', $row->start_time);
            $end   = Carbon::createFromFormat('H:i:s', $row->end_time);
            $totalMinutes += $start->diffInMinutes($end);
        }
    }
    // Convert total minutes to hours (rounded to 2 decimal places)
    $totalHours = round($totalMinutes / 60, 2);

    // Pass $groupedRows to the Blade view
    return view('timesheet.show', compact(
        'timesheet',
        'groupedRows',  
        'weeklyTotal',
        'totalHours'
    ));
}

    // Edit a timesheet
    public function edit($id)
{
    // Decrypt the ID at url line
    try {
        $decryptedId = Crypt::decrypt($id);
    } catch (DecryptException $e) {
        abort(404);
    }

    $timesheet = Timesheet::with('user', 'rows')->findOrFail($decryptedId);

    // Calculate total hours for the week
    $weeklyTotal = $timesheet->rows->sum('total_hours');

    return view('timesheet.edit', compact('timesheet', 'weeklyTotal'));
}


    // Update timesheet 
   public function update(Request $request, $id)
{
    $timesheet = Timesheet::findOrFail($id);

    $timesheet->update($request->only('week', 'month', 'year'));

    if ($request->action === 'submit') {
        // Set status
        $timesheet->status = 'submitted';

        // ✅ Save the exact submission time
        $timesheet->submitted_at = now();

        $timesheet->save();
    }


    // Delete old rows
    $timesheet->rows()->delete();

    if ($request->has('rows')) {
    foreach ($request->rows as $row) {

        // skip completely empty rows
        if (
            empty($row['project']) &&
            empty($row['task']) &&
            empty($row['start_time']) &&
            empty($row['end_time'])
        ) {
            continue;
        }

        $start = isset($row['start_time']) ? Carbon::parse($row['start_time']) : null;
        $end   = isset($row['end_time']) ? Carbon::parse($row['end_time']) : null;

        $totalHours = 0;

        if ($start && $end) {
            if ($end->lt($start)) {
                $totalHours = 0;
            } else {
                $totalHours = round($start->diffInMinutes($end) / 60, 2);
            }
        }

        $timesheet->rows()->create([
            'date'        => $row['date'] ?? $timesheet->start_date,
            'project'     => $row['project'],
            'task'        => $row['task'],
            'start_time'  => $row['start_time'],
            'end_time'    => $row['end_time'],
            'total_hours' => $totalHours,
        ]);
    }
}

    return redirect()->route('timesheet.index')->with('success', 'Timesheet updated successfully!');
}

// Generate PDF export of timesheet
public function exportPdf($id)
{
    $timesheet = Timesheet::with('rows', 'user')->findOrFail($id);

    $totalHours = $timesheet->rows->sum('total_hours');

    return Pdf::loadView('timesheet.pdf', compact('timesheet', 'totalHours'))
        ->setPaper('A4', 'portrait')
        ->download('Timesheet_' . $timesheet->week . '.pdf');
}

    // ------------------------------
    // HR / ADMIN FUNCTIONS
    // ------------------------------

    public function viewTS(Request $request)
    {
        $query = Timesheet::with('user', 'rows');

        if ($request->filled('staff_name')) {
            $query->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->staff_name . '%'));
        }

        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('year')) $query->where('year', $request->year);
        if ($request->filled('month')) $query->where('month', $request->month);
        if ($request->filled('week')) $query->where('week', $request->week);

        $timesheets = $query->orderBy('created_at', 'desc')->get();

        return view('hr.viewTS', compact('timesheets'));
    }

    public function showStaff(Request $request, $userId)
    {
        $user = User::findOrFail($userId);
        $query = Timesheet::where('user_id', $user->id)->with('rows');

        if ($request->filled('year')) $query->where('year', $request->year);
        if ($request->filled('month')) $query->where('month', $request->month);
        if ($request->filled('week')) $query->where('week', $request->week);

        $timesheets = $query->orderBy('week', 'asc')->get();

        return view('hr.showTS', [
            'user' => $user,
            'timesheets' => $timesheets,
            'selectedYear'  => $request->year ?? null,
            'selectedMonth' => $request->month ?? null,
            'selectedWeek'  => $request->week ?? null,
        ]);
    }

    public function details(Request $request, $id)
    {
        $timesheet = Timesheet::with('user', 'rows')->findOrFail($id);

        return view('hr.detailsTS', [
            'timesheet'      => $timesheet,
            'selectedYear'   => $request->year ?? null,
            'selectedMonth'  => $request->month ?? null,
            'selectedWeek'   => $request->week ?? null,
        ]);
    }

    public function generateReport()
    {
        return "Generate report function works!";
    }

    public function indexHr()
    {
        $timesheets = Timesheet::with('user', 'rows')->get();
        return view('hr.timesheets', compact('timesheets'));
    }
}
