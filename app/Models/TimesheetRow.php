<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TimesheetRow extends Model
{
    protected $fillable = [
        'timesheet_id', 
        'date', 
        'project', 
        'task', 
        'start_time', 
        'end_time', 
        'total_hours'
    ];
    public $timestamps = false;


    // each timesheet row belongs to a timesheet
     public function timesheet()
    {
        return $this->belongsTo(Timesheet::class);
    }
}
