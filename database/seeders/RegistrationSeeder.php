<?php

namespace Database\Seeders;

use App\Models\Registration;
use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder
{
    public function run()
    {
        $majors = [
            ['major' => 'Akuntansi dan Keuangan Lembaga', 'quota' => 72],
            ['major' => 'Desain Komunikasi Visual', 'quota' => 72],
            ['major' => 'Manajemen Perkantoran dan Layanan Bisnis', 'quota' => 144],
            ['major' => 'Teknik Kendaraan Ringan', 'quota' => 72],
            ['major' => 'Teknik Komputer dan Jaringan', 'quota' => 144],
            ['major' => 'Teknik Sepeda Motor', 'quota' => 72],
        ];

        foreach ($majors as $major) {
            Registration::create($major);
        }
    }
}