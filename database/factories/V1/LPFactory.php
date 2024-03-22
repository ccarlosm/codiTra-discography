<?php

namespace Database\Factories\V1;

use App\Models\V1\Artist;
use App\Models\V1\LP;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LP>
 */
class LPFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $artist = Artist::inRandomOrder()->first();

        if (! $artist) {
            $artist = Artist::factory()->create();
        }

        return [
            'title' => 'LP - '.$this->faker->sentence($nbWords = rand(2, 4), $variableNbWords = true),
            'description' => $this->faker->text(200),
            'artist_id' => $artist->id,
        ];
    }
}
