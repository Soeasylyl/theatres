<?php

namespace App\DTO\Movies;

use Carbon\Carbon;
use Illuminate\Http\UploadedFile;

class UpdateMovieDTO
{
    /**
     * @param int $movieId
     * @param string $name
     * @param string $dateStart
     * @param string $sessionDuration
     * @param string $rating
     * @param int $ageLimit
     * @param string $description
     * @param UploadedFile|null $moviePoster
     * @param array|null $movieFrames
     */
    public function __construct(
        private readonly int $movieId,
        private readonly string $name,
        private readonly string $dateStart,
        private readonly string $sessionDuration,
        private readonly string $rating,
        private readonly int $ageLimit,
        private readonly string $description,
        private readonly ?UploadedFile $moviePoster,
        private readonly ?array $movieFrames,
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
     * @return UploadedFile|null
     */
    public function getMoviePoster(): ?UploadedFile
    {
        return $this->moviePoster;
    }

    /**
     * @return array|null
     */
    public function getMovieFrames(): ?array
    {
        return $this->movieFrames;
    }
}
