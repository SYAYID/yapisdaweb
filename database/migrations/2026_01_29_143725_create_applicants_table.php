<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->string('registration_number')->unique();
            $table->string('kk_area'); // Dalam/Luar Banten
            $table->string('kk_number', 16);
            $table->string('nik', 16)->unique();
            $table->string('nisn')->nullable();
            $table->string('full_name');
            $table->enum('gender', ['Laki-laki', 'Perempuan']);
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('religion');
            $table->string('phone');
            $table->string('email');
            $table->string('previous_school');
            $table->string('major_choice');
            $table->enum('citizenship', ['WNI', 'WNA']);
            $table->string('birth_certificate_number');
            $table->integer('height');
            $table->integer('weight');
            $table->integer('head_circumference')->nullable();
            $table->integer('siblings_count');
            $table->integer('child_order');
            $table->string('disability')->default('Tidak Ada');
            
            // Alamat KTP Orang Tua
            $table->string('parent_ktp_village');
            $table->string('parent_ktp_rt');
            $table->string('parent_ktp_rw');
            $table->string('parent_ktp_subdistrict');
            $table->string('parent_ktp_district');
            $table->string('parent_ktp_province');
            $table->string('parent_ktp_residence_status');
            $table->string('parent_ktp_distance_to_school');
            $table->string('parent_ktp_transportation');
            
            // Alamat Domisili Siswa
            $table->boolean('same_as_ktp')->default(false);
            $table->string('current_village')->nullable();
            $table->string('current_rt')->nullable();
            $table->string('current_rw')->nullable();
            $table->string('current_subdistrict')->nullable();
            $table->string('current_district')->nullable();
            $table->string('current_province')->nullable();
            $table->string('current_residence_status')->nullable();
            $table->string('current_distance_to_school')->nullable();
            $table->string('current_transportation')->nullable();
            
            // Data Ayah
            $table->string('father_nik');
            $table->string('father_name');
            $table->string('father_birth_place');
            $table->date('father_birth_date');
            $table->string('father_education');
            $table->string('father_occupation');
            $table->string('father_income');
            $table->string('father_phone');
            $table->string('father_disability')->default('Tidak Ada');
            
            // Data Ibu
            $table->string('mother_nik');
            $table->string('mother_name');
            $table->string('mother_birth_place');
            $table->date('mother_birth_date');
            $table->string('mother_education');
            $table->string('mother_occupation');
            $table->string('mother_income');
            $table->string('mother_phone');
            $table->string('mother_disability')->default('Tidak Ada');
            
            // Data Wali (nullable)
            $table->boolean('has_guardian')->default(false);
            $table->string('guardian_nik')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_birth_place')->nullable();
            $table->date('guardian_birth_date')->nullable();
            $table->string('guardian_education')->nullable();
            $table->string('guardian_occupation')->nullable();
            $table->string('guardian_income')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->string('guardian_disability')->nullable();
            
            // Upload Files
            $table->string('photo_path');
            $table->string('kk_path');
            $table->string('birth_certificate_path');
            $table->string('mother_ktp_path');
            $table->string('father_ktp_path');
            $table->string('guardian_ktp_path')->nullable();
            $table->string('diploma_path')->nullable();
            $table->string('report_card_path');
            
            // Status
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('applicants');
    }
};