<?php

namespace App\Console\Commands;

use App\Models\Schedule;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateScheduleStatus extends Command
{
    protected $signature = 'schedule:update-status';
    protected $description = 'Update status of all schedules based on their time';

    public function handle()
    {
        $this->info('Starting schedule status update...');

        try {
            DB::beginTransaction();

            $schedules = Schedule::where('status', '!=', 'completed')->get();
            $updated = 0;

            foreach ($schedules as $schedule) {
                $oldStatus = $schedule->status;
                $schedule->updateStatus();
                
                if ($oldStatus !== $schedule->status) {
                    $schedule->saveQuietly();
                    $updated++;
                    $this->info("Updated schedule '{$schedule->schedule_name}' from {$oldStatus} to {$schedule->status}");
                }
            }

            DB::commit();
            $this->info("Successfully updated {$updated} schedules");

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("Error updating schedules: " . $e->getMessage());
        }
    }
} 