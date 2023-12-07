<?php

namespace App\DTO\Halls;

class RenderSeatsDTO
{
    /**
     * @param int $seatsTypeId
     * @param int $countSeats
     * @param int $numberRow
     * @param string $htmlContent
     */
    public function __construct(
        private readonly int $seatsTypeId,
        private readonly int $countSeats,
        private readonly int $numberRow,
        private readonly string $htmlContent,
    )
    {
    }

    /**
     * @return int
     */
    public function getSeatsTypeId(): int
    {
        return $this->seatsTypeId;
    }

    /**
     * @return int
     */
    public function getCountSeats(): int
    {
        return $this->countSeats;
    }

    /**
     * @return int
     */
    public function getNumberRow(): int
    {
        return $this->numberRow;
    }

    /**
     * @return string
     */
    public function getHtmlContent(): string
    {
        return $this->htmlContent;
    }
}
