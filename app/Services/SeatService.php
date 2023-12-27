<?php

namespace App\Services;

use App\DTO\Seats\CreateSeatDTO;
use App\DTO\Seats\CheckAndDeleteSeatDTO;
use App\DTO\Seats\UpdateSeatDTO;
use App\Models\Seat;
use App\Repositories\HallRepository;
use App\Repositories\SeatRepository;


class SeatService
{
    public function __construct(
        private readonly SeatRepository $seatRepository,
        private readonly HallRepository $hallRepository,
    )
    {
    }

    /**
     * Updates the information of a seat in the repository based on the provided UpdateSeatDTO.
     *
     * @param UpdateSeatDTO $dto
     * @return Seat
     */
    public function updateSeat(UpdateSeatDto $dto): Seat
    {
        $seat = $this->seatRepository->getSeatForCreationChecking(
            theatreId: $dto->getTheatreId(),
            hallId: $dto->getHallId(),
            seatsTypeId: $dto->getSeatTypeId(),
            seatId: $dto->getSeatId(),
        );

        return $this->seatRepository->updateSeat(
            seat: $seat,
            hallId: $dto->getHallId(),
            seatsTypeId: $dto->getSeatTypeId(),
            rowNumber: $dto->getRow(),
            seatNumber: $dto->getNumber(),
            positionX: $dto->getPosX(),
            positionY: $dto->getPosY(),
        );
    }

    /**
     * Deletes a seat based on the provided DTO.
     *
     * @param CheckAndDeleteSeatDTO $dto
     * @return bool
     */
    public function deleteSeat(CheckAndDeleteSeatDTO $dto): bool
    {
        $seat = $this->seatRepository->getSeatWithTheatreAndHallChecking(
            theatreId: $dto->getTheatreId(),
            hallId: $dto->getHallId(),
            seatId: $dto->getSeatId(),
        );

        return $seat->delete();
    }

    /**
     * Creates a new seat in the repository based on the provided CreateSeatDTO.
     *
     * @param CreateSeatDTO $dto
     * @return Seat
     */
    public function createSeat(CreateSeatDTO $dto): Seat
    {
        $hall = $this->hallRepository->getHallForCreationChecking(
            theatreId: $dto->getTheatreId(),
            hallId: $dto->getHallId(),
            seatsTypeId: $dto->getSeatTypeId(),
        );

        return $this->seatRepository->createSeat(
            hall: $hall,
            seatsTypeId: $dto->getSeatTypeId(),
            rowNumber: $dto->getRow(),
            seatNumber: $dto->getNumber(),
            positionX: $dto->getPosX(),
            positionY: $dto->getPosY(),
        );
    }

    /**
     * Find a seat with its type based on the provided CheckAndDeleteSeatDTO.
     *
     * @param CheckAndDeleteSeatDTO $dto
     * @return array
     */
    public function findSeatWithSeatType(CheckAndDeleteSeatDTO $dto): array
    {
        $seat = $this->seatRepository->getSeatWithTheatreAndHallChecking(
            theatreId: $dto->getTheatreId(),
            hallId: $dto->getHallId(),
            seatId: $dto->getSeatId(),
            columns: ['seat_type_id', 'row', 'number', 'position_x', 'position_y'],
        );

        $seatType = $seat->seatType->name;

        return ['seat' => $seat, 'seatType' => $seatType];
    }
}
