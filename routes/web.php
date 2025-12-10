<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\TimesheetController;
use App\Http\Controllers\TimesheetRowController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/login', [CustomAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomAuthController::class, 'login']);
Route::post('/logout', [CustomAuthController::class, 'logout'])->name('logout');

//Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

//Weekly Timesheet Route
    Route::get('/timesheet', [TimesheetController::class, 'index'])->name('timesheet.index');
    Route::get('/timesheet/add', [TimesheetController::class, 'create'])->name('timesheet.create');
    Route::get('/timesheet/{id}', [TimesheetController::class, 'show'])->name('timesheet.show');
    Route::get('/timesheet/{id}/edit', [TimesheetController::class, 'edit'])->name('timesheet.edit');

    //Timesheet Routes
    Route::middleware(['auth'])->group(function () {
    Route::get('/timesheet', [TimesheetController::class, 'index'])->name('timesheet.index'); //list timesheets by week
    Route::get('/timesheet/create', [TimesheetController::class, 'create'])->name('timesheet.create'); //create new timesheet
    Route::post('/timesheet', [TimesheetController::class, 'store'])->name('timesheet.store'); //save data
    Route::resource('timesheet', TimesheetController::class)->middleware('auth');
    Route::post('/timesheet/store', [TimesheetController::class, 'store'])->name('timesheet.store');
    //Route::post('/timesheet-rows', [TimesheetRowController::class, 'store'])->name(name: 'timesheet-rows.store');
    Route::get('/timesheet/{id}/edit', [TimesheetController::class, 'edit'])->name('timesheet.edit');
    Route::put('/timesheet/{id}', [TimesheetController::class, 'update'])->name('timesheet.update');


    Route::middleware('auth')->group(function () {

    Route::resource('timesheet', TimesheetController::class);

});

});
});



require __DIR__.'/auth.php';
