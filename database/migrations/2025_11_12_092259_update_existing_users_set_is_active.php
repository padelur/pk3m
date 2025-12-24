<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Set semua user yang sudah ada menjadi aktif
        // Super Admin selalu aktif, tapi kita set juga untuk konsistensi
        DB::table('users')->whereNull('is_active')->orWhere('is_active', 0)->update([
            'is_active' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Tidak perlu rollback, biarkan is_active tetap seperti sekarang
    }
};
