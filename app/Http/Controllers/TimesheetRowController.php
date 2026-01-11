<?php

namespace App\Http\Controllers;

use App\Models\TimesheetRow;
use Illuminate\Http\Request;

class TimesheetRowController extends Controller
{
   public function store(Request $request)
{
    // Validate basic timesheet info
    $validated = $request->validate([
        'week' => 'required',
        'month' => 'required',
        'year' => 'required',
        //'position' => 'required',
        //'rows' => 'required|array',
    ]);

    //Create main timesheet entry
    $timesheet = \App\Models\Timesheet::create([
        'user_id' => auth()->id(),
        'week' => $request->week,
        'month' => $request->month,
        'year' => $request->year,
        //'position' => $request->position,
        'status' => $request->action === 'submit' ? 'Submitted' : 'Saved'
    ]);

    // Save each row in timesheet_rows
    foreach ($request->rows as $row) {

        $start = strtotime($row['start']);
        $end = strtotime($row['end']);
        $totalHours = ($end - $start) / 3600;

        TimesheetRow::create([
            'timesheet_id' => $timesheet->id,
            'date' => $row['date'],
            'project_id' => $row['project'],
            'task' => $row['task'],
            'start_time' => $row['start'],
            'end_time' => $row['end'],
            'total_hours' => $totalHours
        ]);
    }

    return redirect()->route('timesheet.index')->with('success', 'Timesheet saved!');
}}