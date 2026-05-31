<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('active_students', function (Blueprint $table) {
            $table->id();
            $table->enum('student_type', ['smk', 'smp'])->index();
            $table->unsignedBigInteger('student_id')->index();
            $table->string('unit', 20)->index();
            $table->string('registration_number', 80)->index();
            $table->string('student_identification_number', 80)->nullable()->index();
            $table->string('full_name');
            $table->string('program')->nullable()->index();
            $table->string('class_group', 80)->nullable()->index();
            $table->enum('status', ['active', 'hold', 'inactive', 'graduated'])->default('active')->index();
            $table->date('enrolled_at')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['student_type', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('active_students');
    }
};
