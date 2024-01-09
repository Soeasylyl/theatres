<?php

namespace App\DTO\Theatres;

use App\Models\Movie;
use Carbon\Carbon;
use DateTimeZone;

class FilterTheatreDTO
{
    /**
     * @param Movie $movie
     * @param int|null $theatreId
     * @param string|null $date
     * @param string|null $timeZone
     * @param string|null $startTime
     * @param string|null $endTime
     */
    public function __construct(
        private readonly Movie   $movie,
        private readonly ?int    $theatreId = null,
        private readonly ?string $date = null,
        private readonly ?string $timeZone = null,
        private readonly ?string $startTime = null,
        private readonly ?string $endTime = null,
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
     * @return int|null
     */
    public function getTheatreId(): ?int
    {
        return $this->theatreId;
    }

    /**
     *  Retrieves the start time of the specified event,
     *  considering default values if not set.
     *
     * @return Carbon
     * @throws \Exception
     */
    public function getStartTime(): Carbon
    {
        $startTime = $this->startTime === null
            ? now()->startOfDay()
            : $this->createDateTime($this->date, $this->startTime);

        return $startTime->lt($this->getDate())
            ? $startTime
            : $this->getDate()->setTimeFrom($startTime);
    }

    /**
     *  Retrieves the end time of the specified event,
     *  handling scenarios where end time is before start time.
     *
     * @return Carbon
     * @throws \Exception
     */
    public function getEndTime(): Carbon
    {
        $endTime = $this->endTime === null
            ? now()->endOfDay()
            : $this->createDateTime($this->date, $this->endTime);

        if (
            (Carbon::parse($this->endTime))
            < (Carbon::parse($this->startTime))
        ) {
             return $endTime->addDay();
        }

        return $endTime->lt($this->getDate())
            ? $endTime
            : $this->getDate()->setTimeFrom($endTime);
    }

    /**
     *  Retrieves the date of the event, defaulting to the current date if not set.
     *
     * @return Carbon|null
     * @throws \Exception
     */
    public function getDate(): ?Carbon
    {
        return $this->date === null
            ? now()->second(0)
            : $this->createDateTime($this->date);
    }

    /**
     *  Creates a Carbon instance based on the provided date and optional time,
     *  considering the configured time zone.
     *
     * @param string|null $date
     * @param string|null $time
     * @return Carbon
     * @throws \Exception
     */
    private function createDateTime(?string $date, ?string $time = null): Carbon
    {
        $dateTime = Carbon::parse($date, $this->getTimeZone());

        if ($time !== null) {
            $timeParts = explode(':', $time);
            $dateTime->setTime(
                hour: $timeParts[0],
                minute: $timeParts[1]
            );
        }

        return $dateTime;
    }

    /**
     * Returns a DateTimeZone object representing the specified time zone.
     *
     * @return DateTimeZone|string
     * @throws \Exception
     */
    private function getTimeZone(): DateTimeZone|string
    {
        return $this->timeZone === null
            ?   date_default_timezone_get()
            :   new DateTimeZone($this->timeZone);
    }
}
