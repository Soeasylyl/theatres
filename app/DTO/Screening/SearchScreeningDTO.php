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
     * @param string|null $fScreenings
     * @param string|null $searchTerm
     */
    public function __construct(
        private readonly User $producer,
        private readonly ?int $theatreId,
        private readonly ?string $date,
        private readonly ?string $fScreenings,
        private readonly ?string $searchTerm,
    )
    {
    }

    /**
     * @return string|null
     */
    public function getSearchTerm(): ?string
    {
        return $this->searchTerm;
    }

    /**
     * @return string|null
     */
    public function getFScreenings(): ?string
    {
        return $this->fScreenings;
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
