<?php

namespace App\Repositories\Interfaces;

use App\DTO\SeatTypes\CreateSeatTypeDTO;
use App\DTO\SeatTypes\UpdateSeatTypeDTO;
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

    /**
     * Get a seat type by its ID or throw an exception if not found.
     *
     * @param int $seatTypeId
     * @param array|null $relations
     * @return SeatType
     */
    public function getSeatTypeByIdOrFail(int $seatTypeId, ?array $relations = []): SeatType;

    /**
     * Update seat type information based on the provided data transfer object (DTO).
     *
     * @param SeatType $seatType
     * @param UpdateSeatTypeDTO $dto
     * @return SeatType
     */
    public function updateInfoBySeatType(SeatType $seatType, UpdateSeatTypeDTO $dto): SeatType;
}
