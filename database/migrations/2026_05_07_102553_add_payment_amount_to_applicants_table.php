<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            // Nominal yang dibayarkan (bisa cicilan)
            $table->decimal('payment_amount', 12, 0)->default(0)->after('payment_method');

            // Total tagihan pembayaran (default 1.000.000)
            $table->decimal('total_payment', 12, 0)->default(1000000)->after('payment_amount');

            // Sisa pembayaran (computed, tapi bisa disimpan untuk performa)
            $table->decimal('payment_remaining', 12, 0)->nullable()->after('total_payment');
        });

        // Update existing records dengan default values
        DB::table('applicants')->update([
            'total_payment' => 1000000,
            'payment_amount' => 0,
        ]);
    }

    public function down(): void
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn(['payment_amount', 'total_payment', 'payment_remaining']);
        });
    }
};