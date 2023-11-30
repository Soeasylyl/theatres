<?php

namespace App\DTO\SeatTypes;

class DeleteSeatTypeDTO
{
    /**
     * @param int $seatTypeId
     */
    public function __construct(
        private readonly int $seatTypeId,
    )
    {
    }

    /**
     * @return int
     */
    public function getSeatTypeId(): int
    {
        return $this->seatTypeId;
    }
}
