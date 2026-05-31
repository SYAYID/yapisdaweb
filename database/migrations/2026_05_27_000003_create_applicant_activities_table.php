<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('applicant_activities')) {
            Schema::create('applicant_activities', function (Blueprint $table) {
                $table->id();
                $table->string('applicant_type', 12);
                $table->unsignedBigInteger('applicant_id');
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->string('category', 32)->default('note');
                $table->string('title');
                $table->text('body')->nullable();
                $table->json('metadata')->nullable();
                $table->dateTime('follow_up_at')->nullable();
                $table->boolean('is_pinned')->default(false);
                $table->timestamps();

                $table->index(['applicant_type', 'applicant_id', 'created_at'], 'applicant_activities_lookup_index');
                $table->index(['follow_up_at', 'is_pinned'], 'applicant_activities_follow_up_index');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('applicant_activities');
    }
};
