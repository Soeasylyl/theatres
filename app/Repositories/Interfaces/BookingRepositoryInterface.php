<?php

namespace App\Repositories\Interfaces;

use App\DTO\Halls\CreateHallDTO;
use App\DTO\Halls\UpdateHallDTO;
use App\Models\Theatre;
use App\Models\Hall;
use Illuminate\Database\Eloquent\Collection;

interface BookingRepositoryInterface
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
    ): bool;
}
