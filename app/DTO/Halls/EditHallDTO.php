<?php

namespace App\DTO\Halls;

class EditHallDTO
{

    /**
     * @param int $theatreId
     * @param int $hallId
     */
    public function __construct(
        private readonly int $theatreId,
        private readonly int  $hallId,
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
}
