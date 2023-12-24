<?php

namespace App\DTO\Seats;

class CreateSeatDTO
{
    /**
     * @param int $seatTypeId
     * @param int $hallId
     * @param int $row
     * @param int $number
     * @param float $posX
     * @param float $posY
     */
    public function __construct(
        private readonly int   $seatTypeId,
        private readonly int   $hallId,
        private readonly int   $row,
        private readonly int   $number,
        private readonly float $posX,
        private readonly float $posY,
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
    public function getRow(): int
    {
        return $this->row;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @return float
     */
    public function getPosX(): float
    {
        return $this->posX;
    }

    /**
     * @return float
     */
    public function getPosY(): float
    {
        return $this->posY;
    }
}
