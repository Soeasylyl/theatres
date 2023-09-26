<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SeatType>
 */
class SeatTypeFactory extends Factory
{
    private static $currentIndex = 0;

    public function definition(): array
    {
        $types = [
            'VIP' => [15, 20],
            'Комфорт' => [10, 15],
            'Стандарт' => [7, 10],
            'Эконом' => [3, 7],
        ];

        $typeName = array_keys($types)[self::$currentIndex];
        [$min, $max] = $types[$typeName];

        self::$currentIndex = (self::$currentIndex + 1) % count($types);

        return [
            'name' => $typeName,
            'description' => $this->faker->paragraph(),
            'amount' => $this->faker->randomFloat(2, $min, $max),
        ];
    }
}
