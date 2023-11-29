<?php

namespace App\Services;

use App\DTO\SeatTypes\CreateSeatTypeDTO;
use App\Models\SeatType;
use App\Repositories\Interfaces\SeatTypeRepositoryInterface;
use Illuminate\Support\Facades\Log;

class SeatTypeService
{
    public function __construct(
        private readonly SeatTypeRepositoryInterface $seatTypeRepository
    )
    {
    }

    /**
     * Creates a theater seat type based on the passed DTO data.
     *
     * @param CreateSeatTypeDTO $dto
     * @return SeatType
     */
    public function createSeatTypeByTheatre(CreateSeatTypeDTO $dto): SeatType
    {
        try {
            $seatType = $this->seatTypeRepository->createSeatTypeForTheatre(dto: $dto);
        } catch (\Throwable $e) {
            Log::error("Failed to create seatType: {$e->getMessage()} theatre id: {$dto->getTheatreId()}");
        }

        return $seatType;
    }
}
