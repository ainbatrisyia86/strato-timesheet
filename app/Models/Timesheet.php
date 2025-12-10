<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Timesheet extends Model
{
    // Add 'date' to fillable so you can mass-assign it
    protected $fillable = [
        'user_id',
        'week',
        'month',
        'year',
        //'position',
        'status'
    ];

    // If you want to use timestamps, set this to true
    // public $timestamps = true;
    // Otherwise, leave it false
    public $timestamps = false;

   public function rows()
    {
        return $this->hasMany(TimesheetRow::class);
    }
}
