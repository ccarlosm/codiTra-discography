<?php

namespace Database\Seeders\V1;

use App\Models\V1\Artist;
use Illuminate\Database\Seeder;

class ArtistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create 5 artists
        Artist::withoutEvents(function () {
            Artist::factory()->count(10)->create();
        });
    }
}
