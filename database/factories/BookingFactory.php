<?php

namespace Database\Factories;

use App\Enums\StatusBookingsEnum;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Screening;
use App\Models\Seat;
use App\Models\User;
use App\Services\Currencies\Models\Currency;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state for a booking.
     *
     * @return array|mixed[]
     */
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

    /**
     * Configure the model factory for booking.
     *
     * @return $this
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Booking $booking) {
            Payment::factory()
                ->count(rand(1,2))
                ->create([
                    'booking_id' => $booking->id,
                    'currency_id' => Currency::inRandomOrder()->first()->id,
                ]);
        });
    }
}
