<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::middleware('auth:sanctum')->get('/schedules/check-notifications', function () {
    return Auth::user()->schedules()
        ->where(function ($query) {
            $query->where('status', '!=', 'completed')
                ->where(function ($q) {
                    $q->where('start_schedule', '>=', now()->subMinutes(5))
                        ->orWhere('due_schedule', '>=', now()->subMinutes(5))
                        ->orWhere('before_due_schedule', '>=', now()->subMinutes(5))
                        ->orWhere(function ($q) {
                            $q->where('due_schedule', '<', now())
                                ->where('status', '!=', 'completed');
                        });
                });
        })
        ->select('id', 'schedule_name', 'start_schedule', 'due_schedule', 'before_due_schedule', 'status')
        ->orderBy('due_schedule')
        ->get();
}); 