<?php

namespace App\DTO\Halls;

class GetHallsDTO
{

    /**
     * @param int $theatreId
     */
    public function __construct(
        private readonly int $theatreId,
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
}
