<?php

namespace App\Services;

use App\DTO\Seats\UpdateSeatDTO;
use App\Repositories\SeatRepository;


class SeatService
{
    public function __construct(
        private readonly SeatRepository $seatRepository,
    )
    {
    }

    /**
     * Updates the information of a seat in the repository based on the provided UpdateSeatDTO.
     *
     * @param UpdateSeatDTO $dto
     * @return bool|int
     */
    public function updateSeat(UpdateSeatDto $dto): bool|int
    {
        return $this->seatRepository->updateSeat(
            seatId: $dto->getSeatId(),
            seatsTypeId: $dto->getSeatTypeId(),
            hallId: $dto->getHallId(),
            rowNumber: $dto->getRow(),
            seatNumber: $dto->getNumber(),
            positionX: $dto->getPosX(),
            positionY: $dto->getPosY(),
        );
    }
}
