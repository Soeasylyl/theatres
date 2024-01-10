<?php

namespace App\DTO\Screening;

use App\Models\Movie;

class TimeConversionScreeningDTO
{
    public function __construct(
        private readonly Movie $movie,
        private readonly int   $screeningId,
    )
    {
    }

    /**
     * @return Movie
     */
    public function getMovie(): Movie
    {
        return $this->movie;
    }

    /**
     * @return int
     */
    public function getScreeningId(): int
    {
        return $this->screeningId;
    }
}
