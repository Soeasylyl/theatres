<?php

namespace App\Services;

use App\DTO\Seats\CreateSeatDTO;
use App\DTO\Seats\SeatIdDTO;
use App\DTO\Seats\UpdateSeatDTO;
use App\Models\Seat;
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

    /**
     * Deletes a seat based on the provided DTO.
     *
     * @param SeatIdDTO $dto
     * @return bool
     */
    public function deleteSeat(SeatIdDTO $dto): bool
    {
        return $this->seatRepository->deleteSeatsByIdOrFail(seatId: $dto->getSeatId());
    }

    /**
     * Creates a new seat in the repository based on the provided CreateSeatDTO.
     *
     * @param CreateSeatDTO $dto
     * @return void
     */
    public function createSeat(CreateSeatDTO $dto): void
    {
        $this->seatRepository->createSeat(
            seatsTypeId: $dto->getSeatTypeId(),
            hallId: $dto->getHallId(),
            rowNumber: $dto->getRow(),
            seatNumber: $dto->getNumber(),
            positionX: $dto->getPosX(),
            positionY: $dto->getPosY(),
        );
    }

    /**
     *  Finds a seat by ID.
     *
     * @param SeatIdDTO $dto
     * @return Seat
     */
    public function findSeat(SeatIdDTO $dto): Seat
    {
        return $this->seatRepository->getSeatById(
            seatId: $dto->getSeatId(),
            relations: ['seatType'],
            columns: ['seat_type_id', 'row', 'number', 'position_x', 'position_y'],
        );
    }
}
