<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('applicants', function (Blueprint $table) {
            // ✅ Status pembayaran: enum (hemat space)
            $table->enum('payment_status', ['unpaid', 'pending', 'paid', 'confirmed'])
                  ->default('unpaid')
                  ->after('status');

            // ✅ PATH: Gunakan TEXT agar tidak masuk hitungan row size limit
            $table->text('payment_proof_path')->nullable()->after('payment_status');

            // ✅ Metode: VARCHAR 50 masih aman karena kecil
            $table->string('payment_method', 50)->nullable()->after('payment_status');

            // ✅ Tanggal pembayaran
            $table->timestamp('paid_at')->nullable()->after('payment_status');

            // ✅ Catatan: Gunakan TEXT (bukan VARCHAR)
            $table->text('payment_note')->nullable()->after('payment_status');
        });
    }

    public function down()
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status',
                'payment_proof_path',
                'payment_method',
                'paid_at',
                'payment_note'
            ]);
        });
    }
};