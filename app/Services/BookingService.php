<?php

namespace App\Services;

use App\DTO\Booking\CheckBookingSeatForScreeningDTO;
use App\Repositories\Interfaces\BookingRepositoryInterface;

class BookingService
{

    public function __construct(
        private readonly BookingRepositoryInterface $bookingRepository,
        private readonly HallService $hallService,
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
        $dataSeats = $this->hallService->getHallContent($dto);

        foreach ($dataSeats as &$rows) {
            foreach ($rows as &$seat) {
                foreach ($seat as $seatId => &$value) {

                    $value['isBooking'] = $this->bookingRepository->isSeatBookedForScreening(
                        theatreId: $dto->getTheatreId(),
                        hallId: $dto->getHallId(),
                        screeningId: $dto->getScreeningId(),
                        seatId: $seatId,
                        relations: ['halls.screenings.bookings'],
                    );
                }
            }
        }

        unset($rows, $seat, $value);

        return $dataSeats;
    }

    public function checkSeatStatus(CheckBookingSeatForScreeningDTO $dto)
    {
        if (is_null($dto->getSeatIds())) {
            return null;
        }

        $dataSeats = [];
        foreach ($dto->getSeatIds() as $seatId) {
            $this->bookingRepository->isSeatBookedForScreening(
                theatreId: $dto->getTheatreId(),
                hallId: $dto->getHallId(),
                screeningId: $dto->getScreeningId(),
                seatId: $seatId,
                relations: ['halls.screenings.bookings'],
            );
        }
    }
}
