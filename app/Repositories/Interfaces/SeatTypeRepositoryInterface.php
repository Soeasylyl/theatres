<?php

namespace App\Repositories\Interfaces;

use App\DTO\SeatTypes\CreateSeatTypeDTO;
use App\Models\SeatType;

interface SeatTypeRepositoryInterface
{
    /**
     * Creates a new theater seat type based on the passed data.
     *
     * @param CreateSeatTypeDTO $dto
     * @return SeatType
     */
    public function createSeatTypeForTheatre(CreateSeatTypeDTO $dto): SeatType;

    /**
     * Checks whether places are bound to the specified type.
     *
     * @param int $seatTypeId
     * @return bool
     */
    public function hasSeatsOfType(int $seatTypeId): bool;

    /**
     * Removes a place type from the database.
     *
     * @param int $seatTypeId
     * @return void
     */
    public function deleteSeatType(int $seatTypeId): void;
}
