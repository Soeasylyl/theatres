<?php

namespace App\DTO\Movies;

use Carbon\Carbon;

class EditMovieDTO
{
    /**
     * @param string $name
     * @param string $dateStart
     * @param string $sessionDuration
     * @param string $rating
     * @param int $ageLimit
     * @param string $description
     * @param string|null $moviePoster
     * @param string|null $movieFrames
     */
    public function __construct(
        private readonly string $name,
        private readonly string $dateStart,
        private readonly string $sessionDuration,
        private readonly string $rating,
        private readonly int $ageLimit,
        private readonly string $description,
        private readonly ?string $moviePoster,
        private readonly ?string $movieFrames,
    )
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Carbon
     */
    public function getDateStart(): Carbon
    {
        return Carbon::parse(time: $this->dateStart);
    }

    /**
     * @return Carbon
     */
    public function getSessionDuration(): Carbon
    {
        return Carbon::parse(time: $this->sessionDuration);
    }

    /**
     * @return string
     */
    public function getRating(): string
    {
        return $this->rating;
    }

    /**
     * @return int
     */
    public function getAgeLimit(): int
    {
        return $this->ageLimit;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string|null
     */
    public function getMoviePoster(): ?string
    {
        return $this->moviePoster;
    }

    /**
     * @return string|null
     */
    public function getMovieFrames(): ?string
    {
        return $this->movieFrames;
    }
}
