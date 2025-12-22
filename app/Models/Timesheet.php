<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    use HasFactory;

    // ------------------------------
    // Mass assignable fields
    // ------------------------------
    protected $fillable = [
        'user_id',
        'week',
        'month',
        'year',
        'start_date',
        'end_date',
        // 'date',        // optional, if tracking individual row dates
        // 'project',     // optional, if storing summary info
        // 'task',        // optional
        // 'start_time',  // optional
        // 'end_time',    // optional
        // 'total_hours', // optional
        'status',
        // 'role',        // optional, e.g., user role
    ];

    protected $casts = [
    'start_date' => 'date',
    'end_date'   => 'date',
];

    // ------------------------------
    // Timestamps
    // ------------------------------
    // Set to true if you want created_at / updated_at automatic handling
    public $timestamps = false;

    // ------------------------------
    // Relationships
    // ------------------------------

    // Each timesheet belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Each timesheet can have many rows
    // app/Models/Timesheet.php

    public function rows()
    {
        return $this->hasMany(TimesheetRow::class);
    }

    public function getTotalHoursAttribute()
    {
        return $this->rows->sum('total_hours');
    }

}
