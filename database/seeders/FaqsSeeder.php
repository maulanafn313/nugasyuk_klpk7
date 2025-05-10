<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FaqsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'Apa itu NugasYuk?',
                'answer' => 'NugasYuk adalah platform manajemen tugas dan jadwal belajar yang dirancang khusus untuk membantu mahasiswa mengelola kegiatan akademik mereka.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Bagaimana cara mendaftar di NugasYuk?',
                'answer' => 'Anda dapat mendaftar dengan mengklik tombol "Daftar" di halaman utama, kemudian isi formulir pendaftaran dengan data diri Anda.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Apakah NugasYuk gratis?',
                'answer' => 'Ya, NugasYuk dapat digunakan secara gratis untuk semua mahasiswa.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Bagaimana cara mengatur jadwal di NugasYuk?',
                'answer' => 'Anda dapat mengatur jadwal dengan mengakses menu "Buat Jadwal" dan mengisi detail jadwal yang diinginkan.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'question' => 'Apakah ada fitur pengingat tugas?',
                'answer' => 'Ya, NugasYuk dilengkapi dengan fitur pengingat otomatis yang akan memberitahu Anda tentang deadline tugas dan jadwal belajar.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('faqs')->insert($faqs);
    }
}
