<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    public function definition(): array
    {
        $status = [
            'Pending',
            'Processing',
            'Authorized',
            'Completed',
            'Failed',
            'Refunded' ,
            'Canceled',
        ];

        return [
            'status' => $this->faker->randomElement($status),
            'amount' => fake()->randomFloat(2, 10, 20),
        ];
    }
}
