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

    // Store a new timesheet manually (optional)
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

        // Current week start (Monday) & end (Friday)
        $startDate = Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();
        $endDate   = Carbon::now()->startOfWeek(Carbon::MONDAY)->addDays(4)->toDateString();

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

    // List all timesheets of logged-in staff 
    public function index()
    {
        $userId = auth()->id();

        // Current week start (Monday) & end (Friday)
        $startDate = Carbon::now()->startOfWeek(Carbon::MONDAY)->toDateString();
        $weekEnd   = Carbon::now()->startOfWeek(Carbon::MONDAY)->addDays(4)->toDateString();

        // Auto-create timesheet for current week if not exists
        $exists = Timesheet::where('user_id', $userId)
            ->where('start_date', $startDate)
            ->exists();

        if (!$exists) {
            Timesheet::create([
                'user_id'    => $userId,
                'week'       => Carbon::now()->weekOfYear,
                'month'      => Carbon::now()->month,
                'year'       => Carbon::now()->year,
                'start_date' => $startDate,
                'end_date'   => $weekEnd,
                'status'     => 'open',
            ]);
        }

        // Fetch all timesheets
        $timesheets = Timesheet::where('user_id', $userId)
            ->orderBy('start_date', 'desc')
            ->paginate(10);

        $currentWeekStart = $startDate;

        return view('timesheet.index', compact('timesheets', 'currentWeekStart'));
    }

    // Show single timesheet with its rows
    public function show($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            abort(404);
        }

        $timesheet = Timesheet::with(['rows', 'user'])->findOrFail($decryptedId);

        $totalMinutes = 0;

    foreach ($timesheet->rows as $row) {
        if ($row->start_time && $row->end_time) {
            $start = Carbon::createFromFormat('H:i:s', $row->start_time);
            $end   = Carbon::createFromFormat('H:i:s', $row->end_time);

            $totalMinutes += $start->diffInMinutes($end);
        }
    }

    $totalHours = round($totalMinutes / 60, 2); // e.g. 7.50

    return view('timesheet.show', compact('timesheet', 'totalHours'));
}

    // Edit a timesheet
    public function edit($id)
    {
        try {
            $decryptedId = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            abort(404);
        }

        $timesheet = Timesheet::with('user','rows')->findOrFail($decryptedId);

        return view('timesheet.edit', compact('timesheet'));
    }

    // Update a timesheet and its rows
   public function update(Request $request, $id)
{
    $timesheet = Timesheet::findOrFail($id);

    $timesheet->update($request->only('week', 'month', 'year'));

    if ($request->action === 'submit') {
        $timesheet->status = 'Submitted';
        $timesheet->save();
    }

    // Delete old rows
    $timesheet->rows()->delete();

    if ($request->has('rows')) {
        foreach ($request->rows as $row) {
            $start = isset($row['start']) ? Carbon::parse($row['start']) : null;
            $end   = isset($row['end']) ? Carbon::parse($row['end']) : null;

            $totalHours = 0;
            if ($start && $end) {
                $minutes = $end->diffInMinutes($start);
                $totalHours = round($minutes / 60, 2);
            }

            

            $timesheet->rows()->create([
                'date'        => $row['date'] ?? null,
                'project'     => $row['project'] ?? null,
                'task'        => $row['task'] ?? null,
                'start_time'  => $row['start_time'] ?? null, 
                'end_time'    => $row['end_time'] ?? null,   
                'total_hours' => $totalHours,
            ]);
        }
    }

    return redirect()->route('timesheet.index')->with('success', 'Timesheet updated successfully!');
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
