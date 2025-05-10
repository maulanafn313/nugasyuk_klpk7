<?php

namespace Database\Seeders;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Buat admin user
        $this->call(AdminSeeder::class);

        // Buat 5 user
        $users = User::factory(5)->create();

        // Buat 10 schedule dan hubungkan dengan owner + collaborators
        Schedule::factory(10)->create()->each(function ($schedule) use ($users) {
            // Set owner = user_id di schedule
            $owner = $schedule->owner;

            // Tambahkan beberapa user sebagai kolaborator (termasuk owner juga boleh)
            $collaborators = $users->random(rand(2, 4));

            foreach ($collaborators as $user) {
                $schedule->collaborators()->attach($user->id, [
                    'role' => $user->id === $owner->id ? 'owner' : fake()->randomElement(['editor', 'viewer']),
                ]);
            }
        });

        $this->call([
            CmsSeeder::class,
            FacilitiesSeeder::class,
            FaqsSeeder::class,
        ]);
    }
}
