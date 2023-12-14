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

    /**
     * Gets a Seat by identifier with the ability to load associated data.
     *
     * @param int $seatId
     * @param array|null $relations
     * @return Seat
     */
    public function getSeatById(int $seatId, ?array $relations = []): Seat
    {
        return Seat::with($relations)->find($seatId);
    }

    /**
     * Updates information about the Seat.
     *
     * @param Seat $seat
     * @param int $seatsTypeId
     * @param int $rowNumber
     * @param int $seatNumber
     * @return Seat
     */
    public function updateSeat(
        Seat $seat,
        int  $seatsTypeId,
        int  $rowNumber,
        int  $seatNumber
    ): Seat
    {
        $seat->update([
            'seat_type_id' => $seatsTypeId,
            'row' => $rowNumber,
            'number' => $seatNumber,
            'position_x' => rand(0, 100),
            'position_y' => rand(0, 100),
        ]);

        return $seat;
    }
}
