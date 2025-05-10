<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CmsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cms')->insert([
            'color' => '#3B82F6',
            'logo' => 'cms/logo nugasyuk.png',
            'hero_text' => 'Selamat Datang di NugasYuk',
            'description_text' => 'Platform manajemen tugas dan jadwal belajar terbaik untuk mahasiswa',
            'hero_text2' => 'Fitur Unggulan',
            'description_text2' => 'Nikmati berbagai fitur yang memudahkan pembelajaran Anda',
            'img_text2' => 'cms/planning.svg',
            'hero_text3' => 'Tentang Kami',
            'description_text3' => 'NugasYuk adalah platform yang dirancang khusus untuk membantu mahasiswa mengelola tugas dan jadwal belajar',
            'img_text3' => 'cms/mhs_nugas-Layer 1.jpeg',
            'hero_text4' => 'Bergabung Sekarang',
            'description_text4' => 'Daftar sekarang dan rasakan kemudahan mengelola tugas Anda',
            'img_text4' => 'cms/animasi mahasiswa.png',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
