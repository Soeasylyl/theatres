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
        $status = [
            StatusPaymentsEnum::Pending_Payment->name,
            StatusPaymentsEnum::Payment_Successful->name,
            StatusPaymentsEnum::Payment_Cancelled->name,
            StatusPaymentsEnum::Processing->name,
            StatusPaymentsEnum::Payment_Error->name,
            StatusPaymentsEnum::Refunded->name,
            StatusPaymentsEnum::Completed->name,
        ];

        return [
            'status' => $this->faker->randomElement($status),
            'amount' => fake()->randomFloat(2, 10, 20),
        ];
    }
}
