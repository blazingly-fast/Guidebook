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
    Schema::create('guidebooks', function (Blueprint $table) {
      $table->uuid('id')->primary();
      $table->uuid('user_id')->nullable(false);
      $table->string('title');
      $table->text('description');
      $table->boolean('is_published')->default(false);
      $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
    Schema::dropIfExists('guidebooks');
  }
};
