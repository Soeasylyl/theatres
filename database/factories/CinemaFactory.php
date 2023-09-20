<?php

namespace Database\Factories;

use App\Models\Cinema;
use App\Models\Hall;
use App\Models\SeatType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cinema>
 */
class CinemaFactory extends Factory
{
    public function definition(): array
    {
        $address = fake('ru_RU')
                 ->city . ' ' . fake('ru_RU')
                 ->streetAddress();

        return [
            'name' => fake('ru_RU')->unique()->colorName(),
            'description' => fake('ru_RU')->paragraph(),
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
            });
    }

}
