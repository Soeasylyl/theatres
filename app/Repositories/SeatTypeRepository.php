<?php

namespace App\Repositories;

use App\DTO\SeatTypes\CreateSeatTypeDTO;
use App\DTO\SeatTypes\UpdateSeatTypeDTO;
use App\Models\Seat;
use App\Models\SeatType;
use App\Repositories\Interfaces\SeatTypeRepositoryInterface;
use Illuminate\Support\Collection;

class SeatTypeRepository implements SeatTypeRepositoryInterface
{
    /**
     * Creates a new theater seat type based on the passed data.
     *
     * @param CreateSeatTypeDTO $dto
     * @return SeatType
     */
    public function createSeatTypeForTheatre(CreateSeatTypeDTO $dto): SeatType
    {
        return SeatType::create([
           'name' => $dto->getName(),
           'description' => $dto->getDescription(),
           'amount' => $dto->getAmount(),
           'theatre_id' => $dto->getTheatreId(),
        ]);
    }

    /**
     * Checks whether places are bound to the specified type.
     *
     * @param int $seatTypeId
     * @return bool
     */
    public function hasSeatsOfType(int $seatTypeId): bool
    {
        return Seat::where('seat_type_id', $seatTypeId)->exists();
    }

    /**
     * Removes a place type from the database.
     *
     * @param int $seatTypeId
     * @return void
     */
    public function deleteSeatType(int $seatTypeId): void
    {
        SeatType::where('id', $seatTypeId)->delete();
    }

    /**
     * Get a seat type by its ID or throw an exception if not found.
     *
     * @param int $seatTypeId
     * @param array|null $relations
     * @return SeatType
     */
    public function getSeatTypeByIdOrFail(int $seatTypeId, ?array $relations = []): SeatType
    {
        return SeatType::with($relations)->findOrFail($seatTypeId);
    }

    /**
     * Update seat type information based on the provided data transfer object (DTO).
     *
     * @param SeatType $seatType
     * @param UpdateSeatTypeDTO $dto
     * @return SeatType
     */
    public function updateInfoBySeatType(SeatType $seatType, UpdateSeatTypeDTO $dto): SeatType
    {
        $seatType->update([
            'name' => $dto->getName(),
            'description' => $dto->getDescription(),
            'amount' => $dto->getAmount(),
        ]);

        return  $seatType;
    }

    /**
     * Gets a collection of seat types for the specified theater.
     *
     * @param int $theatreId
     * @return Collection
     */
    public function getSeatTypesByHallId(int $theatreId): Collection
    {
        return SeatType::where('theatre_id', $theatreId)->get();
    }
}
