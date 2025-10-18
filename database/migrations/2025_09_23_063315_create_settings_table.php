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
		Schema::create('settings', function (Blueprint $table) {
			$table->id();
			$table->string('company_name')->nullable();
			$table->string('address')->nullable();
			$table->string('email')->nullable();
			$table->string('phone')->nullable();
			$table->string('whatsapp_link')->nullable();
			$table->string('catalog_pdf_path')->nullable();
			$table->string('map_embed_url')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('settings');
	}
};
