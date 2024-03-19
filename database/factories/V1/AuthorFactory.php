<?php

namespace Database\Factories\V1;

use App\Models\V1\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Author>
 */
class AuthorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'firstname' => $this->faker->unique()->firstName(),
            'lastname' => $this->faker->unique()->lastName(),
        ];
    }
}
