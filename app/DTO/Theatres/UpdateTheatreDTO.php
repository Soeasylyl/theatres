<?php

namespace App\DTO\Theatres;

class UpdateTheatreDTO
{

    /**
     * @param int $theatreId
     * @param string $name
     * @param string $address
     * @param string|null $description
     * @param array|null $theatreImages
     */
    public function __construct(
        private readonly int $theatreId,
        private readonly string $name,
        private readonly string $address,
        private readonly ?string $description,
        private readonly ?array $theatreImages,
    )
    {
    }

    /**
     * @return int
     */
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
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return array|null
     */
    public function getTheatreImages(): ?array
    {
        return $this->theatreImages;
    }
}
