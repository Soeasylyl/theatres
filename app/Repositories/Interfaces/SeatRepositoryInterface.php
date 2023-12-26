<?php

namespace App\Repositories\Interfaces;

use App\Models\Hall;
use App\Models\Seat;

interface SeatRepositoryInterface
{
    /**
     * Create a new seat.
     *
     * @param int $seatsTypeId
     * @param int $hallId
     * @param int $theatreId
     * @param int $rowNumber
     * @param int $seatNumber
     * @param float $positionX
     * @param float $positionY
     * @return Seat
     */
    public function createSeat(
        int   $seatsTypeId,
        int   $hallId,
        int   $theatreId,
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
     * @param int $seatId
     * @param int $seatsTypeId
     * @param int $hallId
     * @param int $rowNumber
     * @param int $seatNumber
     * @param float $positionX
     * @param float $positionY
     * @return bool|int
     */
    public function updateSeat(
        int   $seatId,
        int   $seatsTypeId,
        int   $hallId,
        int   $rowNumber,
        int   $seatNumber,
        float $positionX,
        float $positionY,
    ): bool|int;

    /**
     * Delete seats in a hall that are not present in the given list of seat IDs.
     *
     * @param int $hallId
     * @param array $seatIdsList
     * @return bool
     */
    public function deleteSeatsNotInList(int $hallId, array $seatIdsList): bool;

    /**
     * Deletes a seat with the given seat ID.
     *
     * @param int $seatId
     * @return bool
     */
    public function deleteSeatsByIdOrFail(int $seatId): bool;
}
