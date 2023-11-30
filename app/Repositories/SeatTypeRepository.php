<?php

namespace App\Repositories;

use App\DTO\SeatTypes\CreateSeatTypeDTO;
use App\Models\Seat;
use App\Models\SeatType;
use App\Repositories\Interfaces\SeatTypeRepositoryInterface;

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
           'cinema_id' => $dto->getTheatreId(),
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
        $count = Seat::where('seat_type_id', $seatTypeId)->count();

        return $count > 0;
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
}
