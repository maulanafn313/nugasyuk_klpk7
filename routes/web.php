<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CreateScheduleController;
use App\Models\HomepageContent;
use App\Http\Controllers\Admin\HomepageContentController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

Route::middleware(['auth', 'adminMiddleware'])->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Ini penting! Ganti "users" jadi "userManagement"
    Route::resource('admin/userManagement', AdminUserController::class)->names([
        'index' => 'admin.userManagement.index',
        'create' => 'admin.userManagement.create',
        'store' => 'admin.userManagement.store',
        'show' => 'admin.userManagement.show',
        'edit' => 'admin.userManagement.edit',
        'update' => 'admin.userManagement.update',
        'destroy' => 'admin.userManagement.destroy',
    ]);
});

// Route::get('/', function () {
//     return view('welcome');
// });

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
    Route::put('/schedule/{schedule}', [ScheduleController::class, 'update'])->name('schedule.update');
    Route::delete('/schedule/{schedule}', [ScheduleController::class, 'destroy'])->name('schedule.destroy');
});

//route middleware untuk admin
Route::middleware(['auth', 'adminMiddleware'])->group(function()
{
    Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});

//route untuk homepage
Route::get('/', function () {
    $contents = HomepageContent::all();
    return view('homepage', compact('contents'));
});

Route::resource('homepage-contents', HomepageContentController::class)
    ->middleware(['auth', 'adminMiddleware'])
    ->names('admin.homepage-contents');








require __DIR__.'/auth.php';
