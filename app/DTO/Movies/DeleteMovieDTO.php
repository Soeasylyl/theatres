<?php

namespace App\DTO\Movies;

class DeleteMovieDTO
{
    /**
     * @param int $movieId
     */
    public function __construct(
        private readonly int     $movieId,
    )
    {
    }

    /**
     * @return int
     */
    public function getMovieId(): int
    {
        return $this->movieId;
    }
}
