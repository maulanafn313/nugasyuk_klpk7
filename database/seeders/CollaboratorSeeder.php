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
        //buat user admin
        $admin = User::factory()->create([
            'name' => 'admin nugasyuk',
            'email' => 'maulbackend354@gmail.com',
            'password' => Hash::make('nugasyuksukses'),
            'role' => 'admin',
        ]);

        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        $user3 = User::factory()->create();

        //Buat jadwal oleh admin
        $schedule = Schedule::factory()->create([
            'user_id' => $admin->id,
            'schedule_name' => 'Jadwal Kuliah DPPB',
            'schedule_category' => 'task',
            'priority' => 'important',
            'start_schedule' => '2023-04-10 08:00:00',
            'due_schedule' => '2023-04-10 17:00:00',
            'before_start_schedule' => '2023-04-09 12:00:00',
            'upload_file' => 'file1.pdf',
            'url' => 'https://example.com/file1.pdf',
            'description' => 'Jadwal kuliah DPPB',
            'status' => 'to-do',
        ]);

        // Menambahkan kolaborator ke schedule via pivot table, gunakan attach()
        // Kita asumsikan bahwa owner/pemilik sudah tersimpan di kolaborator juga dengan role Owner
        $schedule->collaborators()->attach($admin->id, ['role' => 'Owner']);
        $schedule->collaborators()->attach($user1->id, ['role' => 'Editor']);
        $schedule->collaborators()->attach($user2->id, ['role' => 'Viewer']);
        $schedule->collaborators()->attach($user3->id, ['role' => 'Editor']);
    }
}
