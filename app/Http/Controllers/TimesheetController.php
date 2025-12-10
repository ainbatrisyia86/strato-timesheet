<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Timesheet;
use App\Models\TimesheetRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TimesheetController extends Controller
{
    public function create()
    {
        // Show the form view (update path if different)
        return view('timesheet.create'); // create resources/views/timesheet/create.blade.php or adjust
    }

   public function store(Request $request)
{
    // 1. Save main timesheet
    $timesheet = Timesheet::create([
        'user_id' => auth()->id(),   // logged in user
        'week'    => $request->week,
        'month'   => $request->month,
        'year'    => $request->year,
        'status'  => $request->action == 'save' ? 'Saved' : 'Submitted',
    ]);

    // 2. Save the row(s)
    if ($request->has('rows')) {
        foreach ($request->rows as $row) {
            TimesheetRow::create([
                'timesheet_id' => $timesheet->id,
                'date' => $row['date'] ?? null,
                'project' => $row['project'] ?? null,
                'task' => $row['task'] ?? null,
                'start_time' => $row['start'] ?? null,
                'end_time' => $row['end'] ?? null,
            ]);
        }
    }

    return redirect()->route('timesheet.index')->with('success', 'Timesheet saved successfully!');
}

    public function index()
{
    // Use paginate (e.g., 10 items per page)
    $timesheets = Timesheet::where('user_id', auth()->id())->paginate(10);

    return view('timesheet.index', compact('timesheets'));
}

public function show($id)
{
    $timesheet = Timesheet::with('rows')->findOrFail($id);

    return view('timesheet.show', [
        'timesheet' => $timesheet,
    ]);
}
public function edit($id)
{
    $timesheet = Timesheet::with('rows')->findOrFail($id);
    return view('timesheet.edit', compact('timesheet'));
}

public function update(Request $request, $id)
{
    $timesheet = Timesheet::findOrFail($id);

    // Update top part
    $timesheet->update($request->only('week','month','year','position'));

    // Handle submit button
    if ($request->action === 'submit') {
        $timesheet->status = 'Submitted';
        $timesheet->save();
    }

    // Delete old rows
    $timesheet->rows()->delete();

    // Re-create rows
    foreach ($request->rows as $row) {
        $timesheet->rows()->create([
            'date'       => $row['date'],
            'project'    => $row['project'],
            'task'       => $row['task'],
            'start_time' => $row['start_time'],  
            'end_time'   => $row['end_time'],   
        ]);
    }

    return redirect()->route('timesheet.index')
                     ->with('success', 'Timesheet updated successfully!');
}




}
