<?php

namespace Database\Factories;

use App\Models\Cinema;
use App\Models\Hall;
use App\Models\Seat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hall>
 */
class HallFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake('ru_RU')->unique()->word(),
            'description' => fake('ru_RU')->paragraph(),
        ];
    }
    public function configure(): static
    {
        return $this->afterCreating(function (Hall $hall) {
            Seat::factory()
                ->count(40)
                ->create(['hall_id' => $hall->id]);
        });
    }
}
