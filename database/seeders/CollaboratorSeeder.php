<?php

namespace Database\Seeders;

use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CollaboratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 users
        $users = [];
        for ($i = 1; $i <= 10; $i++) {
            $users[] = User::factory()->create([
                'name' => 'User ' . $i,
                'email' => 'user' . $i . '@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'user',
            ]);
        }

        // Create schedules for each user
        foreach ($users as $user) {
            for ($i = 1; $i <= 5; $i++) {
                $schedule = Schedule::factory()->create([
                    'user_id' => $user->id,
                    'schedule_name' => 'Schedule ' . $i . ' by ' . $user->name,
                    'schedule_category' => $i % 2 == 0 ? 'task' : 'activities',
                    'priority' => $this->getPriority($i),
                    'start_schedule' => now()->addDays($i),
                    'due_schedule' => now()->addDays($i + 2),
                    'before_due_schedule' => now()->addDays($i + 1),
                    'upload_file' => 'file' . $i . '.pdf',
                    'url' => 'https://example.com/schedule' . $i,
                    'description' => 'This is schedule ' . $i . ' created by ' . $user->name,
                    'status' => $this->getStatus($i),
                ]);

                // Add owner as collaborator with editor role
                $schedule->collaborators()->attach($user->id, ['role' => 'editor']);

                // Add random collaborators (2-3 other users)
                $this->addRandomCollaborators($schedule, $users, $user);
            }
        }
    }

    private function getPriority($index): string
    {
        $priorities = ['important', 'very important', 'not important'];
        return $priorities[$index % 3];
    }

    private function getStatus($index): string
    {
        $statuses = ['to-do', 'processed', 'completed', 'overdue'];
        return $statuses[$index % 4];
    }

    private function addRandomCollaborators($schedule, $users, $owner)
    {
        // Get 2-3 random users (excluding the owner)
        $numCollaborators = rand(2, 3);
        $availableUsers = collect($users)
            ->filter(fn($u) => $u->id != $owner->id)
            ->shuffle()
            ->take($numCollaborators);

        foreach ($availableUsers as $index => $collaborator) {
            $role = $index % 2 == 0 ? 'editor' : 'viewer';
            $schedule->collaborators()->attach($collaborator->id, ['role' => $role]);
        }
    }
}
