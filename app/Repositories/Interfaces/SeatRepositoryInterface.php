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
     * @param float $positionX
     * @param float $positionY
     * @return Seat
     */
    public function createSeat(
        Hall  $hall,
        int   $seatsTypeId,
        int   $rowNumber,
        int   $seatNumber,
        float $positionX,
        float $positionY
    ): Seat;

    /**
     * Gets a Seat by identifier with the ability to load associated data.
     *
     * @param int $seatId
     * @param array|null $relations
     * @return Seat
     */
    public function getSeatById(int $seatId, ?array $relations = []): Seat;

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
    ): Seat;
}
