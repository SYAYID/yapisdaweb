<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orang_tuas', function (Blueprint $table) {
            // Ayah
            $table->string('nik_ayah');
            $table->string('nama_ayah');
            $table->string('tempat_lahir_ayah');
            $table->date('tanggal_lahir_ayah');
            $table->string('pendidikan_ayah');
            $table->string('pekerjaan_ayah');
            $table->string('penghasilan_ayah');
            $table->string('hp_ayah');
            $table->string('disabilitas_ayah')->nullable();

            // Ibu
            $table->string('nik_ibu');
            $table->string('nama_ibu');
            $table->string('tempat_lahir_ibu');
            $table->date('tanggal_lahir_ibu');
            $table->string('pendidikan_ibu');
            $table->string('pekerjaan_ibu');
            $table->string('penghasilan_ibu');
            $table->string('hp_ibu');
            $table->string('disabilitas_ibu')->nullable();
            // ... (lanjutkan sama seperti ayah)

            // Wali
            $table->boolean('ada_wali')->default(false); // centang jika ada wali
            $table->string('nik_wali')->nullable();
            $table->string('nama_wali')->nullable();
            $table->string('tempat_lahir_wali');
            $table->date('tanggal_lahir_wali');
            $table->string('pendidikan_wali');
            $table->string('pekerjaan_wali');
            $table->string('penghasilan_wali');
            $table->string('hp_wali');
            $table->string('disabilitas_wali')->nullable();
// ... (sama)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orang_tuas');
    }
};
