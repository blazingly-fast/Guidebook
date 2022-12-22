<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('places', function (Blueprint $table) {
			$table->uuid('id')->primary();
			$table->uuid('guidebook_id');
			$table->string('title');
			$table->text('description');
			$table->foreign('guidebook_id')->references('id')->on('guidebooks')->onDelete('cascade');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('places');
	}
};
