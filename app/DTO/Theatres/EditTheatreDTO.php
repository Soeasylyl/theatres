<?php

namespace App\DTO\Theatres;

class EditTheatreDTO
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
