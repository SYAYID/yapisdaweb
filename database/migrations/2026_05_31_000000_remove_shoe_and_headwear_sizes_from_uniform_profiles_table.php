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
        Schema::table('uniform_profiles', function (Blueprint $table) {
            $table->dropColumn(['shoe_size', 'headwear_size']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('uniform_profiles', function (Blueprint $table) {
            $table->string('shoe_size', 20)->nullable();
            $table->string('headwear_size', 20)->nullable();
        });
    }
};
