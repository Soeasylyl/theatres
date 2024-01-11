<?php

namespace App\DTO\Booking;

class CheckBookingSeatForScreeningDTO
{
    /**
     * @param int $theatreId
     * @param int $hallId
     * @param int $screeningId
     * @param array|null $seatIds
     */
    public function __construct(
        private readonly int    $theatreId,
        private readonly int    $hallId,
        private readonly int    $screeningId,
        private readonly ?array $seatIds = null,
    )
    {
    }

    /**
     * @return array|null
     */
    public function getSeatIds(): ?array
    {
        return $this->seatIds;
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
    public function getScreeningId(): int
    {
        return $this->screeningId;
    }
}
