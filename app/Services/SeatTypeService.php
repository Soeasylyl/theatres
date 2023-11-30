<?php

namespace App\Services;

use App\DTO\SeatTypes\CreateSeatTypeDTO;
use App\DTO\SeatTypes\DeleteSeatTypeDTO;
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

    /**
     * Deletes a seat type after checking whether seats of this type are associated with the hall.
     *
     * @param DeleteSeatTypeDTO $dto
     * @return void
     * @throws \Exception
     */
    public function deleteSeatTypeWithCheck(DeleteSeatTypeDTO $dto): void
    {
        $hasSeats = $this->seatTypeRepository->hasSeatsOfType(seatTypeId: $dto->getSeatTypeId());

        ! $hasSeats ? $this->seatTypeRepository->deleteSeatType(seatTypeId: $dto->getSeatTypeId())
                  : throw new \Exception('Невозможно удалить тип мест, который уже используется');
    }
}
