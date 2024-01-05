<?php

namespace App\DTO\Theatres;

use App\Models\Movie;
use Carbon\Carbon;

class FilterTheatreDTO
{
    /**
     * @param Movie $movie
     * @param int|null $theatreId
     * @param string|null $date
     * @param string|null $timeZone
     */
    public function __construct(
        private readonly Movie   $movie,
        private readonly ?int    $theatreId = null,
        private readonly ?string $date = null,
        private readonly ?string $timeZone = null,
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
     *  Get the formatted date based on the provided timezone.
     *
     *  If no timezone is specified, return the original date string.
     *  If a timezone is specified, parse the date, adjust to the server's timezone,
     *  and then shift to the specified timezone before returning the formatted date string.
     *
     * @return Carbon|null
     */
    public function getDate(): ?Carbon
    {
        return $this->date === null || $this->date === now()->toDateString()
            ? Carbon::parse(now())
            : Carbon::parse($this->date)
                ->setTimezone(now()->timezone->getName())
                ->shiftTimezone($this->timeZone);
    }

    /**
     * @return string|null
     */
    public function getTimeZone(): ?string
    {
        return $this->timeZone;
    }

    /**
     * @return Movie
     */
    public function getMovie(): Movie
    {
        return $this->movie;
    }
}
