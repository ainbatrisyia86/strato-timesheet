<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timesheet;
use App\Models\TimesheetRow;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TimesheetController extends Controller
{
    // ------------------------------
    // User Functions
    // ------------------------------

    // Show form to create a timesheet
    public function create()
    {
        return view('timesheet.create');
    }

    // Store a new timesheet
    public function store(Request $request)
    {
        $timesheet = Timesheet::create([
            'user_id' => auth()->id(),
            'week'    => $request->week,
            'month'   => $request->month,
            'year'    => $request->year,
            'status'  => $request->action == 'save' ? 'Saved' : 'Submitted',
        ]);

        if ($request->has('rows')) {
            foreach ($request->rows as $row) {
                TimesheetRow::create([
                    'timesheet_id' => $timesheet->id,
                    'date'         => $row['date'] ?? null,
                    'project'      => $row['project'] ?? null,
                    'task'         => $row['task'] ?? null,
                    'start_time'   => $row['start'] ?? null,
                    'end_time'     => $row['end'] ?? null,
                ]);
            }
        }

        return redirect()->route('timesheet.index')->with('success', 'Timesheet saved successfully!');
    }

    // List timesheets for logged-in user
    public function index()
    {
        $timesheets = Timesheet::where('user_id', auth()->id())->paginate(10);
        return view('timesheet.index', compact('timesheets'));
    }

    // Show single timesheet
    public function show($id)
    {
        $timesheet = Timesheet::with('rows')->findOrFail($id);
        return view('timesheet.show', compact('timesheet'));
    }

    // Edit a timesheet
    public function edit($id)
    {
        $timesheet = Timesheet::with('rows')->findOrFail($id);
        return view('timesheet.edit', compact('timesheet'));
    }

    // Update a timesheet
    public function update(Request $request, $id)
    {
        $timesheet = Timesheet::findOrFail($id);

        // Update main fields
        $timesheet->update($request->only('week', 'month', 'year', 'position'));

        if ($request->action === 'submit') {
            $timesheet->status = 'Submitted';
            $timesheet->save();
        }

        // Delete old rows
        $timesheet->rows()->delete();

        // Recreate rows
        foreach ($request->rows as $row) {
            $timesheet->rows()->create([
                'date'       => $row['date'],
                'project'    => $row['project'],
                'task'       => $row['task'],
                'start_time' => $row['start_time'],
                'end_time'   => $row['end_time'],
            ]);
        }

        return redirect()->route('timesheet.index')->with('success', 'Timesheet updated successfully!');
    }

    // ------------------------------
    // HR / Admin Functions
    // ------------------------------

    // View all timesheets with filters (HR)
    public function viewTS(Request $request)
    {
        $query = Timesheet::with('user');

        if ($request->filled('staff_name')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->staff_name . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $date_range = null;
        if ($request->filled('month') && $request->filled('week')) {
            $month = (int) $request->month;
            $week = (int) $request->week;
            $year = now()->year;

            $start = Carbon::createFromDate($year, $month, 1)->addDays(($week - 1) * 7);
            $end = $start->copy()->addDays(6);

            $query->whereBetween('date', [$start->toDateString(), $end->toDateString()]);
            $date_range = $start->format('d/m/Y') . ' - ' . $end->format('d/m/Y');
        }

        $timesheets = $query->orderBy('date', 'asc')->get();

        return view('hr.viewTS', compact('timesheets', 'date_range'));
    }

    // Show all timesheets for a specific staff (HR)
public function showStaff(Request $request, $userId)
{
    // Find the user first (throws 404 if not found)
    $user = User::findOrFail($userId);

    // Start building the query
    $query = Timesheet::where('user_id', $user->id)->with('user');

    // Use year from request or fallback to the year of the timesheet date
    $year = $request->filled('year') ? (int)$request->year : null;

    // Filter by month and week if provided
    if ($request->filled('month')) {
        $month = (int)$request->month;

        // If week is provided, calculate start/end dates of that week
        if ($request->filled('week')) {
            $week = (int)$request->week;

            // Use the requested year if provided, else fallback to now()->year
            $weekYear = $year ?? now()->year;

            // Start date = first day of month + (week-1)*7 days
            $start = Carbon::createFromDate($weekYear, $month, 1)->addDays(($week - 1) * 7);
            $end = $start->copy()->endOfWeek();

            $query->whereBetween('date', [$start->toDateString(), $end->toDateString()]);
        } else {
            // Only month is selected, filter all timesheets in that month
            $monthYear = $year ?? now()->year;
            $query->whereMonth('date', $month)
                  ->whereYear('date', $monthYear);
        }
    } elseif ($year) {
        // Only year is selected
        $query->whereYear('date', $year);
    }

    // Fetch the timesheets sorted by date
    $timesheets = $query->orderBy('date', 'asc')->get();

    // Pass the selected filters to Blade if needed
    return view('hr.showTS', [
        'user'       => $user,
        'timesheets' => $timesheets,
        'selectedYear'  => $year,
        'selectedMonth' => $request->month ?? null,
        'selectedWeek'  => $request->week ?? null,
    ]);
}


    // Details of a timesheet (HR)
    public function details(Request $request, $id)
    {
        $timesheet = Timesheet::with('user')->findOrFail($id);

        $selectedWeek = $request->query('week');
        $selectedMonth = $request->query('month');
        $selectedYear = $request->query('year');
        $selectedPosition = $timesheet->user->role;

        $timesheets = Timesheet::where('user_id', $timesheet->user_id)->get();

        return view('hr.detailsTS', compact(
            'timesheet', 'timesheets', 'selectedWeek', 'selectedMonth', 'selectedYear', 'selectedPosition'
        ));
    }

    // Generate report (placeholder)
    public function generateReport()
    {
        return "Generate report function works!";
    }

    // HR index (optional)
    public function indexHr()
    {
        $timesheets = Timesheet::with('user')->get();
        return view('hr.timesheets', compact('timesheets'));
    }
}
