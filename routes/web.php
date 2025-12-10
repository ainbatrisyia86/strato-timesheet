<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\SettingsController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login', [CustomAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomAuthController::class, 'login']);
Route::post('/logout', [CustomAuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // ---------------------------
    // User Profile
    // ---------------------------
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ---------------------------
    // Staff Timesheet Routes
    // ---------------------------
    Route::middleware(\App\Http\Middleware\RoleMiddleware::class . ':staff')->group(function () {
        Route::get('/timesheets', [TimesheetController::class, 'index'])->name('timesheet.index'); // List staff timesheets
        Route::get('/timesheets/create', [TimesheetController::class, 'create'])->name('timesheet.create'); // Create form
        Route::post('/timesheets', [TimesheetController::class, 'store'])->name('timesheet.store'); // Store new timesheet
        Route::get('/timesheets/{id}', [TimesheetController::class, 'show'])->name('timesheet.show'); // Show single timesheet
        Route::get('/timesheets/{id}/edit', [TimesheetController::class, 'edit'])->name('timesheet.edit'); // Edit form
        Route::put('/timesheets/{id}', [TimesheetController::class, 'update'])->name('timesheet.update'); // Update timesheet
    });

    // ---------------------------
    // HR Routes
    // ---------------------------
    Route::middleware(\App\Http\Middleware\RoleMiddleware::class . ':hr')->group(function () {

        // View all timesheets
        Route::get('/hr/viewTS', [TimesheetController::class, 'viewTS'])->name('hr.viewTS');
        Route::get('/hr/timesheets', [TimesheetController::class, 'indexHr'])->name('hr.timesheets');

        // Specific staff timesheets
        Route::get('/hr/timesheets/{userId}', [TimesheetController::class, 'showStaff'])->name('timesheet.view');

        // Single timesheet details
        Route::get('/hr/timesheet/details/{id}', [TimesheetController::class, 'details'])->name('hr.detailsTS');

        // Report
        Route::get('/hr/generate-report', [TimesheetController::class, 'generateReport'])->name('hr.generateReport');

        // Settings
        Route::prefix('settings')->group(function () {
            Route::get('/users', [SettingsController::class, 'manageUsers'])->name('manage.users');
            Route::get('/projects', [SettingsController::class, 'manageProjects'])->name('manage.projects');
            Route::get('/configuration', [SettingsController::class, 'config'])->name('settings.configuration');
        });
    });

    // ---------------------------
    // Admin Routes
    // ---------------------------
    Route::middleware(\App\Http\Middleware\RoleMiddleware::class . ':admin')->group(function () {
        Route::get('/admin', function () {
            return 'Admin Page';
        });
    });
});

/* Include Laravel auth scaffolding (Breeze / Fortify routes) */
require __DIR__.'/auth.php';
