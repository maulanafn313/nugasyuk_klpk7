<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CreateScheduleController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//route middleware untuk user
Route::middleware(['auth', 'userMiddleware'])->group(function()
{
    Route::get('dashboard', [UserController::class, 'index'])->name('dashboard');
    Route::get('view-schedule', [ScheduleController::class, 'index'])->name('user.view-schedule');
    Route::get('create-schedule', [CreateScheduleController::class, 'index'])->name('user.create-schedule');
    Route::post('store-schedule', [CreateScheduleController::class, 'store'])->name('user.store-schedule');
    // Route::get('history-schedule', [ScheduleController::class, 'index'])->name('user.history-schedule');
});

//route middleware untuk admin
Route::middleware(['auth', 'adminMiddleware'])->group(function()
{
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});





require __DIR__.'/auth.php';
