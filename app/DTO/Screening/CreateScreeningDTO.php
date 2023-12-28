<?php

namespace App\DTO\Screening;

use App\Models\User;
use Carbon\Carbon;

class CreateScreeningDTO
{
    public function __construct(
        private readonly User    $producer,
        private readonly int     $theatreId,
        private readonly int     $hallId,
        private readonly int     $movieId,
        private readonly float   $price,
        private readonly string  $dateStart,
        private readonly ?string $timeZone = 'UTC',
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
     * @return User
     */
    public function getProducer(): User
    {
        return $this->producer;
    }

    /**
     * @return int
     */
    public function getTheatreId(): int
    {
        return $this->theatreId;
    }

    /**
     * @return int
     */
    public function getHallId(): int
    {
        return $this->hallId;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     *  Get the session start date adjusted for the specified time zone.
     *
     *  This method parses the expiration date from the original format, shifts the time zone.
     *  to the specified time zone, and then sets the time zone to match the application's current time zone.
     *  The resulting Carbon instance represents the expiration date in the application's time zone.
     *
     * @return string
     */
    public function getDateStart(): string
    {
        return Carbon::parse(time: $this->dateStart)
            ->shiftTimezone(value: $this->timeZone)
            ->setTimezone(value: now()->timezone->getName());
    }

    /**
     * @return string|null
     */
    public function getTimeZone(): ?string
    {
        return $this->timeZone;
    }
}
