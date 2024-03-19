<?php

namespace Database\Seeders\V1;

use App\Models\V1\Author;
use App\Models\V1\Song;
use Illuminate\Database\Seeder;

class SongAuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Get all the songs
        $songs = Song::all();
        if (Author::count() > 0) {
            //For each song we must create a relationship with one or two authors
            foreach ($songs as $song) {
                $number_of_authors = rand(1, 2);
                $authors = Author::inRandomOrder()->take($number_of_authors)->get();

                foreach ($authors as $author) {
                    $song->authors()->attach($author->id);
                }
            }
        }
    }
}
