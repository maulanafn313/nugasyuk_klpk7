<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateUserStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user status based on schedule activity';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting user status update...');

        // Ambil semua user kecuali admin
        $users = User::where('role', '!=', 'admin')->get();
        $inactiveThreshold = Carbon::now()->subDays(30); // User dianggap tidak aktif jika tidak membuat jadwal dalam 30 hari
        $updatedCount = 0;

        foreach ($users as $user) {
            try {
                // Cek jadwal terakhir yang dibuat user
                $lastSchedule = $user->schedules()->latest()->first();
                $oldStatus = $user->is_active;
                
                // Update status berdasarkan aktivitas jadwal
                if (!$lastSchedule || $lastSchedule->created_at < $inactiveThreshold) {
                    $user->update(['is_active' => false]);
                    if ($oldStatus !== false) {
                        $this->info("User {$user->name} set to inactive (no recent activity)");
                        $updatedCount++;
                    }
                } else {
                    $user->update(['is_active' => true]);
                    if ($oldStatus !== true) {
                        $this->info("User {$user->name} set to active");
                        $updatedCount++;
                    }
                }
            } catch (\Exception $e) {
                $this->error("Error updating status for user {$user->name}: {$e->getMessage()}");
            }
        }

        $this->info("Status update completed. {$updatedCount} users were updated.");
    }
}
