<?php

namespace App\DTO\Halls;

class EditHallDTO
{

    /**
     * @param int $theatresId
     * @param int $hallId
     */
    public function __construct(
        private readonly int $theatresId,
        private readonly int  $hallId,
    )
    {
    }

    /**
     * @return int
     */
    public function getTheatresId(): int
    {
        return $this->theatresId;
    }

    /**
     * @return int
     */
    public function getHallId(): int
    {
        return $this->hallId;
    }
}
