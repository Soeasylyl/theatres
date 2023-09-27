<?php

namespace Database\Factories;

use App\Enums\StatusBookingsEnum;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Screening;
use App\Models\Seat;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    public function definition(): array
    {
        $screening = Screening::select('id')->inRandomOrder()->first();
        $seat = Seat::query()
            ->whereHas('hall.screenings', function (Builder $builder) use ($screening) {
                $builder->where('id', $screening->id);
            })
            ->inRandomOrder()
            ->first();

        return [
            'uuid' => $this->faker->uuid(),
            'slug' => $this->faker->slug,
            'status' => $this->faker->randomElement(StatusBookingsEnum::asSelectArray())['value'],
            'user_id' => User::inRandomOrder()->first()->id,
            'screening_id' => $screening->id,
            'seat_id' => $seat->id,
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
