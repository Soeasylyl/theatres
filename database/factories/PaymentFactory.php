<?php

namespace Database\Factories;

use App\Enums\StatusPaymentsEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement(StatusPaymentsEnum::asSelectArray())['value'],
            'amount' => fake()->randomFloat(2, 10, 20),
        ];
    }
}
