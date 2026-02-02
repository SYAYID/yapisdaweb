<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('major');
            $table->integer('quota');
            $table->integer('used_quota')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('registrations');
    }
};