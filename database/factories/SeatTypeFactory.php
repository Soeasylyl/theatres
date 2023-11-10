<?php

namespace Database\Factories;

use App\Models\SeatType;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends Factory<SeatType>
 */
class SeatTypeFactory extends Factory
{
    /**
     * @var int
     */
    private static int $currentIndex = 0;

    /**
     * Define the model's default state.
     *
     * @return array The model's default state.
     */
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
