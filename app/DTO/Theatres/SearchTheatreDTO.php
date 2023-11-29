<?php

namespace App\DTO\Theatres;

use App\Models\User;

class SearchTheatreDTO
{
    /**
     * @param User $producer
     * @param string|null $searchTerm
     */
    public function __construct(
        private readonly User    $producer,
        private readonly ?string $searchTerm,
    )
    {
    }

    /**
     * @return User
     */
    public function getProducer(): User
    {
        return $this->producer;
    }

    /**
     * @return string|null
     */
    public function getSearchTerm(): ?string
    {
        return $this->searchTerm;
    }
}
