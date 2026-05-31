<?php

namespace Database\Seeders;

use App\Models\SmpRegistration;
use Illuminate\Database\Seeder;

class SmpRegistrationSeeder extends Seeder
{
    public function run(): void
    {
        $programs = [
            ['school_program' => 'Sekolah Umum', 'quota' => 144],
            ['school_program' => 'Sekolah dan Asrama', 'quota' => 72],
        ];

        foreach ($programs as $program) {
            SmpRegistration::updateOrCreate(
                ['school_program' => $program['school_program']],
                ['quota' => $program['quota']]
            );
        }
    }
}
