<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('uniform_stock_items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('category', ['shirt', 'pants', 'skirt', 'headwear', 'shoes', 'attribute', 'other'])->default('other')->index();
            $table->string('size', 40)->nullable()->index();
            $table->string('unit', 40)->default('pcs');
            $table->integer('stock_qty')->default(0);
            $table->integer('reserved_qty')->default(0);
            $table->integer('distributed_qty')->default(0);
            $table->integer('minimum_qty')->default(0);
            $table->text('notes')->nullable();
            $table->foreignId('created_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->unique(['name', 'category', 'size']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('uniform_stock_items');
    }
};
