<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Bersihkan data yang tidak valid (product_id yang tidak ada di products)
        DB::table('product_audits')
            ->whereNotIn('product_id', function ($query) {
                $query->select('id')->from('products');
            })
            ->whereNotNull('product_id')
            ->update(['product_id' => null]);

        // Cek apakah foreign key ada sebelum drop
        $foreignKeys = DB::select("
            SELECT CONSTRAINT_NAME 
            FROM information_schema.KEY_COLUMN_USAGE 
            WHERE TABLE_SCHEMA = DATABASE() 
            AND TABLE_NAME = 'product_audits' 
            AND COLUMN_NAME = 'product_id' 
            AND REFERENCED_TABLE_NAME IS NOT NULL
        ");

        if (!empty($foreignKeys)) {
            Schema::table('product_audits', function (Blueprint $table) {
                // pastikan foreign key lama dihapus terlebih dahulu
                $table->dropForeign(['product_id']);
            });
        }

        Schema::table('product_audits', function (Blueprint $table) {
            // ubah kolom product_id menjadi nullable
            $table->unsignedBigInteger('product_id')->nullable()->change();

            // tambahkan kembali FK dengan nullOnDelete
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('product_audits', function (Blueprint $table) {
            $table->dropForeign(['product_id']);
        });

        Schema::table('product_audits', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable(false)->change();

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->cascadeOnDelete();
        });
    }
};
