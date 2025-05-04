<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Update status setiap menit
        $schedule->command('schedule:update-status')->everyMinute();
        
        // Atau bisa diatur sesuai kebutuhan
        // $schedule->command('schedule:update-status')->everyFiveMinutes();
        // $schedule->command('schedule:update-status')->hourly();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}