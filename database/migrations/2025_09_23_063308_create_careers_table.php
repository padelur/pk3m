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
		Schema::create('careers', function (Blueprint $table) {
			$table->id();
			$table->string('title');
			$table->longText('description')->nullable();
			$table->longText('requirements')->nullable();
			$table->enum('status', ['open', 'closed'])->default('open');
			$table->date('closing_date')->nullable();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('careers');
	}
};
