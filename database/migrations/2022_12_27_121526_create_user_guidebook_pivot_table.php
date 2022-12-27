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
        Schema::create('user_guidebook_pivot', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->uuid('user_id')->nullable(false);
            $table->uuid('guidebook_id')->nullable(false);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('guidebook_id')->references('id')->on('guidebooks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_guidebook_pivot');
    }
};
