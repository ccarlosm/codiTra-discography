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
        Schema::create('songs', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('')->index('songs_title');
            $table->unsignedBigInteger('l_p_id')->index('l_p_id');
            $table->timestamps();
        });

        //Create foreign key
        Schema::table('l_p_s', function (Blueprint $table) {
            $table->foreign('l_p_id', 'songs_l_p_id_foreign')->references('id')->on('l_p_s')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('songs');
    }
};
