<?php

namespace App\Repositories;

use App\Models\Theatre;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class BookingRepository implements BookingRepositoryInterface
{
    /**
     *  Checks whether the specified seat is reserved for a specific screening in the auditorium.
     *
     * @param int $theatreId
     * @param int $hallId
     * @param int $screeningId
     * @param int $seatId
     * @param array $relations
     * @return bool
     */
    public function isSeatBookedForScreening(
        int $theatreId,
        int $hallId,
        int $screeningId,
        int $seatId,
        array $relations = [],
    ): bool
    {
        return Theatre::with($relations)
            ->where('id', $theatreId)
            ->whereHas('halls', fn(Builder $builder) =>
                $builder->where('id', $hallId)
                        ->whereHas('screenings', fn(Builder $builder) =>
                            $builder->where('id', $screeningId)
                                    ->whereHas('bookings', fn(Builder $builder) =>
                                        $builder->where('seat_id', $seatId))))
            ->exists();
    }
}
