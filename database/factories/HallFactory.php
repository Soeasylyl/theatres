<?php

namespace Database\Factories;

use App\Models\Theatre;
use App\Models\Hall;
use App\Models\Media;
use App\Models\Seat;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @extends Factory<Hall>
 */
class HallFactory extends Factory
{
    /**
     * Define the default attributes for the factory's model.
     *
     * @return array The default attributes for the factory's model.
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word,
            'description' => $this->faker->paragraph,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return static The configured model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Hall $hall) {
            $mediaCount = rand(1, 3);

            Seat::factory()
                ->count(rand(10, 30))
                ->create(['hall_id' => $hall->id]);

            for ($i = 0; $i < $mediaCount; $i++) {
                $hall->medias()->create([
                    'path' => $this->faker->filePath(),
                ]);
            }
        });
    }
}
