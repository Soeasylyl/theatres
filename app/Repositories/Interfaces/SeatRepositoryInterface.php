<?php

namespace App\Repositories\Interfaces;

use App\Models\Hall;
use App\Models\Seat;

interface SeatRepositoryInterface
{
    /**
     * Create a new seat.
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
     * Updates information about the Seat.
     *
     * @param Seat $seat
     * @param int $hallId
     * @param int $seatsTypeId
     * @param int $rowNumber
     * @param int $seatNumber
     * @param float $positionX
     * @param float $positionY
     * @return Seat
     */
    public function updateSeat(
        Seat  $seat,
        int   $hallId,
        int   $seatsTypeId,
        int   $rowNumber,
        int   $seatNumber,
        float $positionX,
        float $positionY,
    ): Seat;

    /**
     *  Retrieve a seat by ID with specified conditions in the associated hall, theatre, and seat type.
     *
     * @param int $theatreId
     * @param int $hallId
     * @param int $seatsTypeId
     * @param int $seatId
     * @return Seat
     */
    public function getSeatForCreationChecking(
        int $theatreId,
        int $hallId,
        int $seatsTypeId,
        int $seatId,
    ): Seat;

    /**
     *  Get a seat by ID, taking into account affiliation with the theater and hall.
     *
     * @param int $theatreId
     * @param int $hallId
     * @param int $seatId
     * @param array|null $columns
     * @return Seat
     */
    public function getSeatWithTheatreAndHallChecking(
        int $theatreId,
        int $hallId,
        int $seatId,
        ?array $columns = ['*']
    ): Seat;
}
