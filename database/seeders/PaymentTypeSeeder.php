<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    public function run(): void
    {
        PaymentType::updateOrCreate(
            ['code' => 'SERAGAM'],
            [
                'name' => 'Uang Seragam',
                'description' => 'Pembayaran wajib seragam siswa.',
                'default_amount' => 1000000,
                'direction' => 'income',
                'is_active' => true,
            ]
        );
    }
}
