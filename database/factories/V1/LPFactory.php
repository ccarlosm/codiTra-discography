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
        //Get the artists and choose the artist with fewer songs
        $artist = Artist::withCount('LPs')->orderBy('LPs_count', 'asc')->first();

        if (!$artist) {
            $artist = Artist::factory()->create();
        }

        return [
            'name' => $this->faker->name,
            'year' => $this->faker->year,
            'artist_id' => $artist->id
        ];
    }
}
