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
}
