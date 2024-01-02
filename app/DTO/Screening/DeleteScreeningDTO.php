<?php

namespace App\DTO\Screening;

use App\Models\User;

class DeleteScreeningDTO
{
    /**
     * @param int $screeningId
     * @param int $theatreId
     * @param User $producer
     */
    public function __construct(
        private readonly int  $screeningId,
        private readonly int  $theatreId,
        private readonly User $producer,
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
     * @return User
     */
    public function getProducer(): User
    {
        return $this->producer;
    }

    /**
     * @return int
     */
    public function getScreeningId(): int
    {
        return $this->screeningId;
    }
}
