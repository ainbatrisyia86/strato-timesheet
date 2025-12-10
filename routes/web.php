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
    // Staff Routes (record timesheet only)
    // ---------------------------
    Route::middleware(\App\Http\Middleware\RoleMiddleware::class . ':staff')->group(function () {
        Route::get('/record-timesheet', function () {
            return view('timesheet.record');
        })->name('timesheet.record');
    });

    // HR Routes (view timesheets + settings)
    Route::middleware(\App\Http\Middleware\RoleMiddleware::class . ':hr')->group(function () {

        Route::prefix('hr')->group(function () {

            Route::get('/viewTS', [TimesheetController::class, 'viewTS'])->name('hr.viewTS');
            Route::get('/timesheets', [TimesheetController::class, 'indexHr'])->name('hr.timesheets');

            // View all timesheets for a specific user
            Route::get('/hr/timesheet/{user}', [TimesheetController::class, 'showStaff'])->name('timesheet.view');

            // View SINGLE timesheet details page
            Route::get('/timesheet/details/{id}', [TimesheetController::class, 'details'])
                ->name('timesheet.details');
        });

        Route::get('/hr/generate-report', [TimesheetController::class, 'generateReport'])
            ->name('hr.generateReport');

        // Settings routes
        Route::prefix('settings')->group(function () {
            Route::get('/users', [SettingsController::class, 'manageUsers'])->name('manage.users');
            Route::get('/projects', [SettingsController::class, 'manageProjects'])->name('manage.projects');
            Route::get('/configuration', [SettingsController::class, 'config'])->name('settings.configuration');
        });
    });


    // ---------------------------
    // Admin Routes (view timesheets + settings)
    // ---------------------------
    Route::get('/admin', function () {
        return 'Admin Page';
    })->middleware(\App\Http\Middleware\RoleMiddleware::class . ':admin');
});

/* Include Laravel auth scaffolding (Breeze / Fortify routes) */
require __DIR__.'/auth.php';

