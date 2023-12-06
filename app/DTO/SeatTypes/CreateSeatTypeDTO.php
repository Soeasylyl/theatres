<?php

namespace App\DTO\SeatTypes;

class CreateSeatTypeDTO
{
    /**
     * @param int $theatreId
     * @param string $name
     * @param string|null $description
     * @param float $amount
     */
    public function __construct(
        private readonly int $theatreId,
        private readonly string $name,
        private readonly ?string $description,
        private readonly float $amount
    )
    {
    }

    public function getTheatreId(): int
    {
        return $this->theatreId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }
}
