<?php

namespace App\DTO\Halls;

class DeleteHallDTO
{

    /**
     * @param int $hallId
     */
    public function __construct(
        private readonly int $hallId,
    )
    {
    }

    /**
     * @return int
     */
    public function getHallId(): int
    {
        return $this->hallId;
    }
}
