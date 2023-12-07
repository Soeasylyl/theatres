<?php

namespace App\Repositories\Interfaces;

use App\Models\Hall;
use App\Models\Seat;

interface SeatRepositoryInterface
{
    /**
     * Create a new seat within the specified hall based on provided seat details.
     *
     * @param Hall $hall
     * @param int $seatsTypeId
     * @param int $rowNumber
     * @param int $seatNumber
     * @return Seat
     */
    public function createSeat(
        Hall $hall,
        int  $seatsTypeId,
        int  $rowNumber,
        int  $seatNumber
    ): Seat;
}
