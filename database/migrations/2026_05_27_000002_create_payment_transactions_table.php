<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('payment_type_id')->nullable()->constrained('payment_types')->nullOnDelete();
            $table->enum('direction', ['income', 'outcome']);
            $table->unsignedBigInteger('amount');
            $table->enum('student_type', ['smk', 'smp'])->nullable();
            $table->foreignId('applicant_id')->nullable()->constrained('applicants')->nullOnDelete();
            $table->foreignId('smp_applicant_id')->nullable()->constrained('smp_applicants')->nullOnDelete();
            $table->string('payment_method', 50)->default('cash');
            $table->string('reference_number', 80)->nullable()->unique();
            $table->enum('status', ['confirmed', 'void'])->default('confirmed');
            $table->timestamp('paid_at')->index();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['student_type', 'applicant_id']);
            $table->index(['student_type', 'smp_applicant_id']);
            $table->index(['direction', 'status', 'paid_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_transactions');
    }
};
