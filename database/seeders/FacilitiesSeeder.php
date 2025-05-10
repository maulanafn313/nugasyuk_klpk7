<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacilitiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facilities = [
            [
                'img' => 'cms/calendar.svg',
                'title' => 'Manajemen Jadwal',
                'description' => 'Atur jadwal belajar Anda dengan mudah dan efisien',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'img' => 'cms/task.svg',
                'title' => 'Manajemen Tugas',
                'description' => 'Kelola tugas-tugas Anda dengan sistem yang terorganisir',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'img' => 'cms/planning.svg',
                'title' => 'Pengingat Otomatis',
                'description' => 'Dapatkan notifikasi untuk deadline tugas dan jadwal belajar',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'img' => 'cms/task.svg',
                'title' => 'Tracking Progress',
                'description' => 'Pantau perkembangan belajar Anda secara real-time',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('facilities')->insert($facilities);
    }
}
