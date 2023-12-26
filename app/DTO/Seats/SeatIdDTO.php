<?php

namespace App\DTO\Seats;

class SeatIdDTO
{
    /**
     * @param int $theatreId
     * @param int $hallId
     * @param int $seatId
     */
    public function __construct(
        private readonly int $theatreId,
        private readonly int $hallId,
        private readonly int $seatId,
    )
    {
    }

    /**
     * @return int
     */
    public function getTheatreId(): int
    {
        return $this->theatreId;
    }

    /**
     * @return int
     */
    public function getHallId(): int
    {
        return $this->hallId;
    }

    /**
     * @return int
     */
    public function getSeatId(): int
    {
        return $this->seatId;
    }
}
