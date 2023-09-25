<?php

namespace Database\Factories;

use App\Enums\StatusBookingsEnum;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Screening;
use App\Models\Seat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    public function definition(): array
    {
        $status = [
            StatusBookingsEnum::Active->name,
            StatusBookingsEnum::Cancelled->name,
            StatusBookingsEnum::Confirmed->name,
            StatusBookingsEnum::Declined->name,
            StatusBookingsEnum::Pending_Payment->name,
            StatusBookingsEnum::Completed->name,
            StatusBookingsEnum::Expired->name,
        ];

        return [
            'uuid' => $this->faker->uuid(),
            'slug' => $this->faker->slug,
            'status' => $this->faker->randomElement($status),
            'user_id' => User::inRandomOrder()->first()->id,
            'screening_id' => Screening::inRandomOrder()->first()->id,
            'seat_id' => Seat::inRandomOrder()->first()->id,
        ];
    }
    public function configure(): static
    {
        return $this->afterCreating(function (Booking $booking) {
            Payment::factory()
                ->count(rand(1,2))
                ->create(['booking_id' => $booking->id]);
        });
    }
}
