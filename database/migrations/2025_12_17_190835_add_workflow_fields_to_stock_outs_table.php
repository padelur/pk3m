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
        Schema::table('stock_outs', function (Blueprint $table) {
            $table->enum('status', ['Draft', 'Approved', 'Completed'])->default('Draft')->after('created_by');
            $table->foreignId('approved_by')->nullable()->constrained('users')->after('status');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            $table->timestamp('completed_at')->nullable()->after('approved_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_outs', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['status', 'approved_by', 'approved_at', 'completed_at']);
        });
    }
};
