<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UpdateScheduleStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Update status untuk semua schedule yang belum completed
            Schedule::where('status', '!=', 'completed')
                ->chunk(100, function ($schedules) {
                    foreach ($schedules as $schedule) {
                        $oldStatus = $schedule->status;
                        $schedule->updateStatus();
                        
                        if ($oldStatus !== $schedule->status) {
                            $schedule->save();
                        }
                    }
                });
        }
        return $next($request);
    }
}
