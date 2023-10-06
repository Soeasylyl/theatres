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
            $mediaCount = rand(1, 3);

            Seat::factory()
                ->count(rand(20, 80))
                ->create(['hall_id' => $hall->id]);

            for ($i = 0; $i < $mediaCount; $i++) {
                $hall->medias()->create([
                    'path' => $this->faker->filePath(),
                ]);
            }
        });
    }
}
