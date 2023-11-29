<?php

namespace App\Repositories;

use App\DTO\SeatTypes\CreateSeatTypeDTO;
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
}
