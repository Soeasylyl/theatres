<?php

namespace App\Services\Currencies\Factories;

use App\Services\Currencies\Models\Currency;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CurrencyFactory extends Factory
{
    protected $model = Currency::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => $this->faker->unique()->randomElement([
                'USD',
                'BTC',
            ]),
            'name' => $this->faker->randomElement([
                'Доллар США',
                'Биткоин',
            ]),
        ];
    }
}
