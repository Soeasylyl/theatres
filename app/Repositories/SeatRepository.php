<?php

namespace App\Repositories;

use App\Models\Hall;
use App\Models\Seat;
use App\Repositories\Interfaces\SeatRepositoryInterface;

class SeatRepository implements SeatRepositoryInterface
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
    ): Seat
    {
        return $hall->seats()->create([
            'seat_type_id' => $seatsTypeId,
            'row' => $rowNumber,
            'number' => $seatNumber,
            'position_x' => rand(0, 100),
            'position_y' => rand(0, 100),
        ]);
    }
}
