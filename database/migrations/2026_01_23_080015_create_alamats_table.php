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
        Schema::create('alamats', function (Blueprint $table) {
            $table->id();
                $table->foreignId('siswa_id')->constrained()->onDelete('cascade');
                $table->string('kampung_ktp');
                $table->string('rt_ktp');
                $table->string('rw_ktp');
                $table->string('desa_kelurahan_ktp');
                $table->string('kecamatan_ktp');
                $table->string('provinsi_ktp');

                // Domisili
                $table->boolean('domisili_sama_ktp')->default(false);
                $table->string('kampung_domisili')->nullable();
                $table->string('rt_domisili')->nullable();
                $table->string('rw_domisili')->nullable();
                $table->string('desa_kelurahan_domisili')->nullable();
                $table->string('kecamatan_domisili')->nullable();
                $table->string('provinsi_domisili')->nullable();

                $table->enum('status_tempat_tinggal', ['Milik Sendiri', 'Sewa', 'Kontrak', 'Bersama Keluarga', 'Asrama', 'Lainnya'])->nullable();
                $table->enum('jarak_ke_sekolah', ['<1 km', '1-3 km', '3-5 km', '>5 km'])->nullable();
                $table->string('moda_transportasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamats');
    }
};
