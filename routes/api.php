<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ScheduleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Route untuk mendapatkan data user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route untuk login
Route::post('login', [AuthController::class, 'login']);

// Route untuk mendapatkan data jadwal
Route::get('/schedules', [ScheduleController::class, 'getSchedules']);

// Route yang dilindungi oleh Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('user', UserController::class);
    Route::apiResource('schedules', ScheduleController::class);
    Route::post('logout', [AuthController::class, 'logout']);
});
