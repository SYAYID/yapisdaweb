<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('applicants') && !Schema::hasColumn('applicants', 'student_identification_number')) {
            Schema::table('applicants', function (Blueprint $table) {
                $table->string('student_identification_number', 20)->nullable()->unique()->after('nisn');
                $table->timestamp('student_identification_assigned_at')->nullable()->after('student_identification_number');
            });
        }

        if (Schema::hasTable('smp_applicants') && !Schema::hasColumn('smp_applicants', 'student_identification_number')) {
            Schema::table('smp_applicants', function (Blueprint $table) {
                $table->string('student_identification_number', 20)->nullable()->unique()->after('nisn');
                $table->timestamp('student_identification_assigned_at')->nullable()->after('student_identification_number');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('applicants') && Schema::hasColumn('applicants', 'student_identification_number')) {
            Schema::table('applicants', function (Blueprint $table) {
                $table->dropUnique('applicants_student_identification_number_unique');
                $table->dropColumn(['student_identification_number', 'student_identification_assigned_at']);
            });
        }

        if (Schema::hasTable('smp_applicants') && Schema::hasColumn('smp_applicants', 'student_identification_number')) {
            Schema::table('smp_applicants', function (Blueprint $table) {
                $table->dropUnique('smp_applicants_student_identification_number_unique');
                $table->dropColumn(['student_identification_number', 'student_identification_assigned_at']);
            });
        }
    }
};
