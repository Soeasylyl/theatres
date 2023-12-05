<?php

namespace App\DTO\Movies;

class SearchMovieDTO
{
    /**
     * @param string|null $searchTerm
     */
    public function __construct(
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
}
