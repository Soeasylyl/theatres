<?php

namespace Database\Factories;

use App\Models\Hall;
use App\Models\Seat;
use App\Models\SeatType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Seat>
 */
class SeatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array The model's default state.
     */
    public function definition(): array
    {
        return [
            'seat_type_id' => SeatType::inRandomOrder()->first()->id,
            'row' => rand(1,10),
            'number' =>rand(1,30),
            'position_x' => rand(-50,50),
            'position_y' => rand(-50,50),
        ];
    }
}
