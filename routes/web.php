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
    return redirect()->route('timesheet.index');
})->middleware('auth');

Route::get('/dashboard', function () {
    // redirect any request to dashboard to /timesheets
    return redirect()->route('timesheet.index');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|-----------------------------------------------------------------------
| AUTHENTICATION ROUTES
|-----------------------------------------------------------------------
*/
Route::get('/register', [CustomAuthController::class, 'register'])->name('register');
Route::post('/register', [CustomAuthController::class, 'storeUser']);

Route::get('/login', [CustomAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomAuthController::class, 'login']);
Route::post('/logout', [CustomAuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| AUTHENTICATED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // ------------------- User Profile -------------------
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ------------------- Staff Timesheet Routes -------------------
    Route::middleware(\App\Http\Middleware\RoleMiddleware::class . ':staff')->group(function () {
        Route::get('/timesheets', [TimesheetController::class, 'index'])->name('timesheet.index');
        Route::get('/timesheets/create', [TimesheetController::class, 'create'])->name('timesheet.create');
        Route::post('/timesheets', [TimesheetController::class, 'store'])->name('timesheet.store');
        Route::get('/timesheets/{id}', [TimesheetController::class, 'show'])->name('timesheet.show');
        Route::get('/timesheets/{id}/edit', [TimesheetController::class, 'edit'])->name('timesheet.edit');
        Route::put('/timesheets/{id}', [TimesheetController::class, 'update'])->name('timesheet.update');
    //     Route::get('/timesheet/{id}/pdf', [TimesheetController::class, 'exportPdf'])
    // ->name('timesheet.pdf');

    });

    // ------------------- HR Routes -------------------
    Route::middleware(\App\Http\Middleware\RoleMiddleware::class . ':hr')->group(function () {

        // Timesheets
        Route::get('/hr/viewTS', [TimesheetController::class, 'viewTS'])->name('hr.viewTS');
        Route::get('/hr/timesheets', [TimesheetController::class, 'indexHr'])->name('hr.timesheets');
        Route::get('/hr/timesheets/{userId}', [TimesheetController::class, 'showStaff'])->name('timesheet.view');
        Route::get('/hr/timesheet/details/{id}', [TimesheetController::class, 'details'])->name('hr.detailsTS');
        Route::get('/hr/generate-report', [TimesheetController::class, 'generateReport'])->name('hr.generateReport');

        // Settings
        Route::prefix('settings')->group(function () {

            // Users Management
            Route::get('/users', [SettingsController::class, 'manageUsers'])->name('manage.users');
            Route::get('/users/{id}/edit', [SettingsController::class, 'editUser'])->name('users.edit');
            Route::put('/users/{id}', [SettingsController::class, 'updateUser'])->name('users.update');
            // Delete User
            Route::delete('/settings/users/{id}', [SettingsController::class, 'destroy'])->name('users.destroy');


            // Projects
            Route::get('/projects', [SettingsController::class, 'manageProjects'])->name('manage.projects');

            // System Configuration
            Route::get('/configuration', [SettingsController::class, 'config'])->name('settings.configuration');
        });
    });

    // ------------------- Admin Routes -------------------
    Route::middleware(\App\Http\Middleware\RoleMiddleware::class . ':admin')->group(function () {
        Route::get('/admin', function () {
            return 'Admin Page';
        });
    });
});

/* Laravel auth scaffolding */
require __DIR__.'/auth.php';
