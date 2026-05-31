<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('student_final_checklists', function (Blueprint $table) {
            $table->id();
            $table->enum('student_type', ['smk', 'smp'])->index();
            $table->unsignedBigInteger('student_id')->index();
            $table->boolean('documents_complete')->default(false);
            $table->boolean('administration_complete')->default(false);
            $table->boolean('student_number_assigned')->default(false);
            $table->boolean('card_printed')->default(false);
            $table->boolean('uniform_size_recorded')->default(false);
            $table->boolean('attribute_distributed')->default(false);
            $table->enum('final_status', ['needs_review', 'ready', 'finalized', 'blocked'])->default('needs_review')->index();
            $table->text('notes')->nullable();
            $table->foreignId('reviewed_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamps();

            $table->unique(['student_type', 'student_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_final_checklists');
    }
};
