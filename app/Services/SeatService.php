<?php

namespace App\Services;

use App\DTO\Seats\CreateSeatDTO;
use App\DTO\Seats\SeatIdDTO;
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
        $seat = $this->seatRepository->getSeatByIdWithTheatreAndHallAndSeatTypeConditionsOrFail(
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
     * @param SeatIdDTO $dto
     * @return bool
     */
    public function deleteSeat(SeatIdDTO $dto): bool
    {
        $seat = $this->seatRepository->getSeatByIdWithTheatreAndHallConditionsOrFail(
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
        $hall = $this->hallRepository->getHallWithTheatreAndSeatTypeConditionsByIdOrFail(
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
     * Find a seat with its type based on the provided SeatIdDTO.
     *
     * @param SeatIdDTO $dto
     * @return array
     */
    public function findSeatWithSeatType(SeatIdDTO $dto): array
    {
        $seat = $this->seatRepository->getSeatByIdWithTheatreAndHallConditionsOrFail(
            theatreId: $dto->getTheatreId(),
            hallId: $dto->getHallId(),
            seatId: $dto->getSeatId(),
            columns: ['seat_type_id', 'row', 'number', 'position_x', 'position_y'],
        );

        $seatType = $seat->seatType->name;

        return ['seat' => $seat, 'seatType' => $seatType];
    }
}
