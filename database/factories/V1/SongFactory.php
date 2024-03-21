<?php

namespace Database\Factories\V1;

use App\Models\V1\LP;
use App\Models\V1\Song;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

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

        $lp = LP::inRandomOrder()->first();

        if (!$lp) {
            $lp = LP::factory()->create();
        }

        return [
            'title' => 'Song - '.$this->faker->sentence($nbWords = rand(3, 7), $variableNbWords = true),
            'l_p_id' => $lp->id,
        ];
    }
}
