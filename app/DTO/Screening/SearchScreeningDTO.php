<?php

namespace App\DTO\Screening;

use App\Models\User;
use Carbon\Carbon;

class SearchScreeningDTO
{
    /**
     * @param User $producer
     * @param int|null $theatreId
     * @param string|null $date
     */
    public function __construct(
        private readonly User $producer,
        private readonly ?int $theatreId,
        private readonly ?string $date,
    )
    {
    }

    /**
     * @return int|null
     */
    public function getTheatreId(): ?int
    {
        return $this->theatreId;
    }

    /**
     * @return Carbon|null
     */
    public function getDate(): ?Carbon
    {
        return $this->date ? Carbon::parse($this->date) : null;
    }

    /**
     * @return User
     */
    public function getProducer(): User
    {
        return $this->producer;
    }
}
