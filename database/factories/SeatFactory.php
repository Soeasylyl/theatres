<?php

namespace Database\Factories;

use App\Models\Hall;
use App\Models\SeatType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seat>
 */
class SeatFactory extends Factory
{
    public function definition(): array
    {
        return [
            'seat_type_id' => SeatType::inRandomOrder()->first()->id,
            'row' => rand(1,10),
            'position_x' => rand(-50,50),
            'position_y' => rand(-50,50),
        ];
    }
}
