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
        Schema::create('song_authors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('song_id')->index('song_id');
            $table->unsignedBigInteger('author_id')->index('author_id');
            $table->timestamps();
        });

        //Create foreign keys
        Schema::table('song_authors', function (Blueprint $table) {
            $table->foreign('song_id', 'song_authors_song_id_foreign')->references('id')->on('songs')->onUpdate('CASCADE')->onDelete('CASCADE');
            $table->foreign('author_id', 'song_authors_author_id_foreign')->references('id')->on('authors')->onUpdate('CASCADE')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('song_authors');
    }
};
