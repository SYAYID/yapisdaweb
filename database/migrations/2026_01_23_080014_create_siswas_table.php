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
       Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->enum('wilayah_kk', ['Dalam Wilayah Banten', 'Luar Wilayah Banten']);
            $table->string('no_kk');
            $table->string('nik');
            $table->string('nisn')->nullable();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('agama', ['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Konghucu']);
            $table->string('no_hp');
            $table->string('email')->nullable();
            $table->string('asal_sekolah');
            $table->string('jurusan_pilihan_1');
            $table->string('jurusan_pilihan_2');
            $table->enum('kewarganegaraan', ['WNI', 'WNA']);
            $table->string('no_akta_lahir')->nullable();
            $table->integer('tinggi_badan');
            $table->integer('berat_badan');
            $table->integer('lingkar_kepala');
            $table->integer('jumlah_saudara');
            $table->integer('anak_ke');
            $table->string('disabilitas')->nullable(); // atau enum jika pilihan tetap
            $table->string('foto_pas')->nullable(); // path file
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
