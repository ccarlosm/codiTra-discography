<?php

namespace Database\Factories\V1;

use App\Models\V1\Song;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Song>
 */
class SongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate a more song-like title using a combination of faker methods
        return [
            'title' => 'Song - ' . $this->faker->sentence($nbWords = rand(3,7), $variableNbWords = true),
        ];
    }
}
