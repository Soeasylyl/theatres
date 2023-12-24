<?php

namespace App\DTO\Seats;

class SeatIdDTO
{
    /**
     * @param int $seatId
     */
    public function __construct(
        private readonly int $seatId,
    )
    {
    }

    /**
     * @return int
     */
    public function getSeatId(): int
    {
        return $this->seatId;
    }
}
