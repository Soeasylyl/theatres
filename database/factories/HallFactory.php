<?php

namespace Database\Factories;

use App\Models\Cinema;
use App\Models\Hall;
use App\Models\Media;
use App\Models\Seat;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hall>
 */
class HallFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->paragraph,
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Hall $hall) {
            Seat::factory()
                ->count(40)
                ->create(['hall_id' => $hall->id]);

            Media::factory()
                ->count(2)
                ->create([
                    'model_type' => Hall::class,
                    'model_id' => $hall->id,
                    'path' => $this->faker->image,
                ]);
        });
    }
}
