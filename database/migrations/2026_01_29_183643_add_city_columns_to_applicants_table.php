<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('applicants', function (Blueprint $table) {
            // Tambah kolom kabupaten/kota untuk alamat KTP orang tua
            $table->text('parent_ktp_city')->after('parent_ktp_district')->nullable();
            
            // Tambah kolom kabupaten/kota untuk alamat domisili siswa
            $table->text('current_city')->after('current_district')->nullable();
        });
    }

    public function down()
    {
        Schema::table('applicants', function (Blueprint $table) {
            $table->dropColumn(['parent_ktp_city', 'current_city']);
        });
    }
};