<?php

namespace App\DTO\SeatTypes;

class UpdateSeatTypeDTO
{

    /**
     * @param int $seatTypeId
     * @param string $name
     * @param string|null $description
     * @param float $amount
     */
    public function __construct(
        private readonly int $seatTypeId,
        private readonly string $name,
        private readonly ?string $description,
        private readonly float $amount,
    )
    {
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getSeatTypeId(): int
    {
        return $this->seatTypeId;
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


}
