<?php

namespace Database\Seeders\V1;

use App\Models\V1\Song;
use Illuminate\Database\Seeder;

class SongSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Create 200 Songs
        Song::withoutEvents(function () {
            Song::factory()->count(100)->create();
        });
    }
}
