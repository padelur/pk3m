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
        Schema::create('stock_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->cascadeOnDelete();
            $table->enum('change_type', ['PO Received', 'Manual Input', 'Adjustment', 'Sale'])->default('Manual Input');
            $table->integer('quantity_change'); // positive for increase, negative for decrease
            $table->integer('stock_before');
            $table->integer('stock_after');
            $table->text('description')->nullable();
            $table->string('reference_number')->nullable(); // PO number, Invoice number, etc
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_logs');
    }
};
