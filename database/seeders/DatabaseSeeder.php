<?php

namespace Database\Seeders;
use App\Models\Cms;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Faq;
use App\Models\User;
use App\Models\Category;
use App\Models\Facility;
use App\Models\HomepageContent;
use App\Models\Schedule;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

       // Buat 5 user
        $users = User::factory(10)->create();

        Category::factory(4)->create();

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

        //buat faqs
        Faq::factory(3)->create();
        //CMS
        Cms::factory()->create();
        //buat facility
        Facility::factory(3)->create();
        //buat homepage contents
        HomepageContent::factory()->create();
    }
}
