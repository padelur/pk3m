<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // MySQL doesn't support direct ENUM modification, so we need to use raw SQL
        DB::statement("ALTER TABLE stock_logs MODIFY COLUMN change_type ENUM('PO Received', 'Manual Input', 'Adjustment', 'Sale', 'Stock Out') DEFAULT 'Manual Input'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original ENUM values
        DB::statement("ALTER TABLE stock_logs MODIFY COLUMN change_type ENUM('PO Received', 'Manual Input', 'Adjustment', 'Sale') DEFAULT 'Manual Input'");
    }
};
