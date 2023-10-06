<?php

namespace Database\Factories;

use App\Models\Cinema;
use App\Models\Hall;
use App\Models\Media;
use App\Models\SeatType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\Relation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cinema>
 */
class CinemaFactory extends Factory
{
    public function definition(): array
    {
        $address = $this->faker
                 ->city . ' ' . fake()
                 ->streetAddress();

        return [
            'name' => $this->faker->unique()->colorName,
            'description' => $this->faker->paragraph,
            'address' => $address,
        ];
    }

    public function configure(): static
    {
            return $this->afterCreating(function (Cinema $cinema) {
                $mediaCount = rand(1, 3);

                SeatType::factory()
                    ->count(4)
                    ->create(['cinema_id' => $cinema->id]);

                Hall::factory()
                    ->count(rand(1, 5))
                    ->create(['cinema_id' => $cinema->id]);

                for ($i = 0; $i < $mediaCount; $i++) {
                    $cinema->medias()->create([
                        'path' => $this->faker->filePath(),
                    ]);
                }
            });
    }
}
