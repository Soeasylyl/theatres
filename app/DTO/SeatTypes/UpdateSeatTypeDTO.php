<?php

namespace App\DTO\SeatTypes;

class UpdateSeatTypeDTO
{

    /**
     * @param int $seatTypeId
     * @param string $name
     * @param string|null $description
     * @param string $amount
     */
    public function __construct(
        private readonly int $seatTypeId,
        private readonly string $name,
        private readonly ?string $description,
        private readonly string $amount,
    )
    {
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

    /**
     * Get the amount as a float, removing the '$' sign if present.
     *
     * @return float
     */
    public function getAmount(): float
    {
        $amount = $this->amount;
        $amount = str_replace('$', '', $amount);

        return floatval($amount);
    }
}
