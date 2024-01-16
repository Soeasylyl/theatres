<?php

namespace Database\Factories;

use App\Enums\StatusPaymentsEnum;
use App\Models\Payment;
use App\Support\Values\AmountValues;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array The model's default state.
     */
    public function definition(): array
    {
        return [
            'status' => $this->faker->randomElement(StatusPaymentsEnum::asSelectArray())['value'],
            'amount' => new AmountValues(fake()->randomFloat(2, 10, 20)),
        ];
    }
}
