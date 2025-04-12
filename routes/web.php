<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\UserController;

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
});

//route middleware untuk admin
Route::middleware(['auth', 'adminMiddleware'])->group(function()
{
    Route::get('admin/dashboard', [UserController::class, 'index'])->name('admin.dashboard');
});





require __DIR__.'/auth.php';
