<?php

namespace App\Services;

use App\DTO\Booking\CheckBookingSeatForScreeningDTO;
use App\Repositories\Interfaces\BookingRepositoryInterface;
use App\Repositories\ScreeningRepository;
use App\Repositories\SeatRepository;

class BookingService
{

    public function __construct(
        private readonly BookingRepositoryInterface $bookingRepository,
        private readonly HallService $hallService,
        private readonly SeatRepository $seatRepository,
        private readonly ScreeningRepository $screeningRepository,
    )
    {
    }

    /**
     *  Generates data about reserved seats for display in the hall.
     *
     * @param CheckBookingSeatForScreeningDTO $dto
     * @return array
     */
    public function generateBookingDataForScreening(CheckBookingSeatForScreeningDTO $dto): array
    {
        $seats = $this->hallService->getHallContent($dto);

        $dataSeats = [];
        foreach ($seats as $seat) {
            $dataSeats[] = [
                'id' => $seat->id,
                'number' => $seat->number,
                'posX' => $seat->position_x,
                'posY' => $seat->position_y,
                'price' => $seat->seatType->amount,
                'row' => $seat->row,
                'seatsTypeId' => $seat->seatType->id,
                'seatsTypeName' => $seat->seatType->name,
                'isBooking' => $this->bookingRepository->isSeatBookedForScreening(
                        theatreId: $dto->getTheatreId(),
                        hallId: $dto->getHallId(),
                        screeningId: $dto->getScreeningId(),
                        seatId: $seat->id,
                        relations: ['halls.screenings.bookings'],
                )
            ];
        }

        return $dataSeats;
    }

    /**
     * Checks the status of selected seats for booking for a specific screening time.
     *
     * @param CheckBookingSeatForScreeningDTO $dto
     * @return array
     * @throws \Exception
     */
    public function checkSeatStatus(CheckBookingSeatForScreeningDTO $dto): array
    {
        if (empty($dto->getSeatIds())) {
            throw new \Exception('Не выбрано места для бронирования');
        }

        $availableSeats = [];
        $bookingSeats = [];
        $totalPrice = 0;
        foreach ($dto->getSeatIds() as $seatId) {
            $isBooking = $this->bookingRepository->isSeatBookedForScreening(
                theatreId: $dto->getTheatreId(),
                hallId: $dto->getHallId(),
                screeningId: $dto->getScreeningId(),
                seatId: $seatId,
                relations: ['halls.screenings.bookings'],
            );

            if (!$isBooking) {
                $seatInfo = $this->seatRepository->getSeatWithTheatreAndHallChecking(
                    theatreId: $dto->getTheatreId(),
                    hallId: $dto->getHallId(),
                    seatId: $seatId,
                    relations: ['seatType'],
                );

                $availableSeats[] = $seatInfo;
                $totalPrice += $seatInfo->seatType->amount;
            } else {
                $bookingSeats[] = $this->seatRepository->getSeatWithTheatreAndHallChecking(
                    theatreId: $dto->getTheatreId(),
                    hallId: $dto->getHallId(),
                    seatId: $seatId,
                    columns: ['id', 'row', 'number'],
                    relations: ['seatType'],
                );
            }
        }

        $screening = $this->screeningRepository->getScreeningByIdOrFail(
            screeningId: $dto->getScreeningId(),
            relations: ['hall.theatre.seatTypes'],
        );

        return [
            'availableSeats' => $availableSeats,
            'bookingSeats' => $bookingSeats,
            'screening' => $screening,
            'totalPrice' => $totalPrice,
        ];
    }
}
