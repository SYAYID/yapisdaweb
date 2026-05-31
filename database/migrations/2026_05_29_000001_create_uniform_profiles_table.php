<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('uniform_profiles', function (Blueprint $table) {
            $table->id();
            $table->enum('student_type', ['smk', 'smp']);
            $table->unsignedBigInteger('student_id');
            $table->string('shirt_size', 20)->nullable();
            $table->string('pants_size', 20)->nullable();
            $table->string('shoe_size', 20)->nullable();
            $table->string('headwear_size', 20)->nullable();
            $table->enum('attribute_status', ['not_recorded', 'recorded', 'prepared', 'distributed'])->default('recorded');
            $table->timestamp('picked_up_at')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('updated_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['student_type', 'student_id']);
            $table->index(['student_type', 'attribute_status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uniform_profiles');
    }
};
