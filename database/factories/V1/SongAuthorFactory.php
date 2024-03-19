<?php

namespace Database\Factories\V1;

use App\Models\V1\Author;
use App\Models\V1\Song;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Song>
 */
class SongAuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if (Author::first() != null) {
            return [
                'song_id' => Song::random()->id,
                'author_id' => Author::random()->id,
            ];
        }
        return [];
    }
}
