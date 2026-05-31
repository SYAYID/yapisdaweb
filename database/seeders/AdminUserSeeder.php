<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admins = [
            [
                'name' => env('ADMIN_SMK_NAME', 'Admin SMKS YAPISDA'),
                'email' => env('ADMIN_SMK_EMAIL'),
                'password' => env('ADMIN_SMK_PASSWORD'),
                'role' => 'admin_smk',
            ],
            [
                'name' => env('ADMIN_SMP_NAME', 'Admin SMPS YAPISDA'),
                'email' => env('ADMIN_SMP_EMAIL'),
                'password' => env('ADMIN_SMP_PASSWORD'),
                'role' => 'admin_smp',
            ],
            [
                'name' => env('FINANCE_ADMIN_NAME', 'Keuangan YAPISDA'),
                'email' => env('FINANCE_ADMIN_EMAIL'),
                'password' => env('FINANCE_ADMIN_PASSWORD'),
                'role' => 'finance',
            ],
            [
                'name' => env('OPERATIONS_ADMIN_NAME', 'Operasional YAPISDA'),
                'email' => env('OPERATIONS_ADMIN_EMAIL'),
                'password' => env('OPERATIONS_ADMIN_PASSWORD'),
                'role' => 'operasional',
            ],
            [
                'name' => env('KEPALA_ADMIN_NAME', 'Kepala Sekolah YAPISDA'),
                'email' => env('KEPALA_ADMIN_EMAIL'),
                'password' => env('KEPALA_ADMIN_PASSWORD'),
                'role' => 'kepala_sekolah',
            ],
            [
                'name' => env('YAYASAN_ADMIN_NAME', 'Yayasan YAPISDA'),
                'email' => env('YAYASAN_ADMIN_EMAIL'),
                'password' => env('YAYASAN_ADMIN_PASSWORD'),
                'role' => 'yayasan',
            ],
        ];

        foreach ($admins as $admin) {
            if (!$admin['email'] || !$admin['password']) {
                continue;
            }

            User::updateOrCreate(
                ['email' => $admin['email']],
                [
                    'name' => $admin['name'],
                    'password' => Hash::make($admin['password']),
                    'role' => $admin['role'],
                ]
            );
        }
    }
}
