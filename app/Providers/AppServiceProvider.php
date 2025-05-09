<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Schedule;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::model('userManagement', User::class);
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $now = Carbon::now();
                $schedules = Schedule::where(function($q){
                        $q->where('user_id', Auth::id())
                          ->orWhereHas('collaborators', fn($q) => $q->where('user_id', Auth::id()));
                    })->get();

                $notifications = collect();
                foreach ($schedules as $s) {
                    $start = Carbon::parse($s->start_schedule);
                    $due   = Carbon::parse($s->due_schedule);
                    $rem   = Carbon::parse($s->before_due_schedule);
                    $oneDayBeforeStart = (clone $start)->subDay();

                    if ($now->between($oneDayBeforeStart, $start, false) && $s->status === 'to-do') {
                        $notifications->push([
                            'type'    => 'info',
                            'message' => "Jadwal <strong>{$s->schedule_name}</strong> akan mulai pada <strong>{$start->format('d F Y H:i')}</strong>."
                        ]);
                    }
                    if ($now->between($start, $due, false) && $s->status === 'to-do') {
                        $notifications->push([
                            'type'    => 'primary',
                            'message' => "Jadwal <strong>{$s->schedule_name}</strong> sudah dimulai, saatnya dikerjakan!"
                        ]);
                    }
                    if ($now->between($rem, $due, false) && $s->status !== 'completed') {
                        $notifications->push([
                            'type'    => 'warning',
                            'message' => "Jadwal <strong>{$s->schedule_name}</strong> mendekati batas waktu <strong>{$due->format('d F Y H:i')}</strong>."
                        ]);
                    }
                    if ($now->gt($due) && $s->status !== 'completed') {
                        $notifications->push([
                            'type'    => 'danger',
                            'message' => "Jadwal <strong>{$s->schedule_name}</strong> sudah melewati batas waktu!"
                        ]);
                    }
                }
            } else {
                $notifications = collect();
            }

            // Share ke semua view
            $view->with('notifications', $notifications);
        });
    }
}
