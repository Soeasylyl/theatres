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
                SeatType::factory()
                    ->count(4)
                    ->create(['cinema_id' => $cinema->id]);

                Hall::factory()
                    ->count(3)
                    ->create(['cinema_id' => $cinema->id]);

                Media::factory()
                    ->count(3)
                    ->create([
                        'model_type' => Cinema::class,
                        'model_id' => $cinema->id,
                        'path' => $this->faker->image,
                    ]);
            });
    }
}
