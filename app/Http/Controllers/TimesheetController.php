<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timesheet;
use App\Models\TimesheetRow;
use App\Models\User;
use Carbon\Carbon;

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

    // Store a new timesheet with rows
    public function store(Request $request)
    {
        $timesheet = Timesheet::create([
            'user_id' => auth()->id(),
            'week'    => $request->week,
            'month'   => $request->month,
            'year'    => $request->year,
            'status'  => $request->action === 'save' ? 'Saved' : 'Submitted',
        ]);

        if ($request->has('rows')) {
            foreach ($request->rows as $row) {
                $start = isset($row['start']) ? Carbon::parse($row['start']) : null;
                $end   = isset($row['end']) ? Carbon::parse($row['end']) : null;
                $totalHours = $start && $end ? round($end->floatDiffInHours($start), 2) : null;

                TimesheetRow::create([
                    'timesheet_id' => $timesheet->id,
                    'date'         => $row['date'] ?? null,
                    'project'      => $row['project'] ?? null,
                    'task'         => $row['task'] ?? null,
                    'start_time'   => $row['start'] ?? null,
                    'end_time'     => $row['end'] ?? null,
                    'total_hours'  => $totalHours,
                ]);
            }
        }

        return redirect()->route('timesheet.index')->with('success', 'Timesheet saved successfully!');
    }

    // List all timesheets of logged-in staff
    public function index()
    {
        $timesheets = Timesheet::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('timesheet.index', compact('timesheets'));
    }

    // Show single timesheet with its rows
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

    // Update a timesheet and its rows
    public function update(Request $request, $id)
    {
        $timesheet = Timesheet::findOrFail($id);

        $timesheet->update($request->only('week', 'month', 'year'));

        if ($request->action === 'submit') {
            $timesheet->status = 'Submitted';
            $timesheet->save();
        }

        // Delete old rows and recreate
        $timesheet->rows()->delete();

        if ($request->has('rows')) {
            foreach ($request->rows as $row) {
                $start = isset($row['start']) ? Carbon::parse($row['start']) : null;
                $end   = isset($row['end']) ? Carbon::parse($row['end']) : null;
                $totalHours = $start && $end ? round($end->floatDiffInHours($start), 2) : null;

                $timesheet->rows()->create([
                    'date'        => $row['date'] ?? null,
                    'project'     => $row['project'] ?? null,
                    'task'        => $row['task'] ?? null,
                    'start_time'  => $row['start'] ?? null,
                    'end_time'    => $row['end'] ?? null,
                    'total_hours' => $totalHours,
                ]);
            }
        }

        return redirect()->route('timesheet.index')->with('success', 'Timesheet updated successfully!');
    }

    // ------------------------------
    // HR / ADMIN FUNCTIONS
    // ------------------------------

    // HR: View all timesheets with optional filters
    public function viewTS(Request $request)
    {
        $query = Timesheet::with('user', 'rows');

        if ($request->filled('staff_name')) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->staff_name . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('year')) $query->where('year', $request->year);
        if ($request->filled('month')) $query->where('month', $request->month);
        if ($request->filled('week')) $query->where('week', $request->week);

        $timesheets = $query->orderBy('created_at', 'desc')->get();

        return view('hr.viewTS', compact('timesheets'));
    }

    // HR: Show timesheets of a specific staff
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

    // HR: Show single timesheet details
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

    // HR: Optional generate report
    public function generateReport()
    {
        return "Generate report function works!";
    }

    // HR: index for all timesheets
    public function indexHr()
    {
        $timesheets = Timesheet::with('user', 'rows')->get();
        return view('hr.timesheets', compact('timesheets'));
    }
}
