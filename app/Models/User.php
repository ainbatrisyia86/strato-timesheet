<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Disable timestamps
    public $timestamps = false;

    // ------------------------------
    // Mass assignable fields
    // ------------------------------
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    // ------------------------------
    // Hidden fields
    // ------------------------------
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // ------------------------------
    // Casts
    // ------------------------------
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // ------------------------------
    // Relationships
    // ------------------------------

    // User has many timesheets
    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }

    // ------------------------------
    // Role Helper Methods
    // ------------------------------
    public function isHr()
    {
        return $this->role === 'hr';
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isStaff()
    {
        return $this->role === 'staff';
    }
}
