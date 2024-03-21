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
        Schema::create('l_p_s', function (Blueprint $table) {
            $table->id();
            $table->string('title')->default('')->index('l_p_s_title');
            $table->string('description')->default('');
            $table->unsignedBigInteger('artist_id')->index('artist_id');
            $table->timestamps();
        });

        //Create foreign key
        Schema::table('l_p_s', function (Blueprint $table) {
            $table->foreign('artist_id')->references('id')->on('artists')->onUpdate('RESTRICT')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('l_p_s');
    }
};
