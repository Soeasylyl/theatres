<?php

namespace Database\Factories;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Genre>
 */
class GenreFactory extends Factory
{
    /**
     * Define the default attributes for the factory's model.
     *
     * @return array The default attributes for the factory's model.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}
