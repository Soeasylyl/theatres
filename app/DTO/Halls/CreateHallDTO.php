<?php

namespace App\DTO\Halls;

class CreateHallDTO
{
    /**
     * @param int $theatreId
     * @param string $name
     * @param string $description
     * @param array|null $hallImages
     */
    public function __construct(
        private readonly int $theatreId,
        private readonly string  $name,
        private readonly string  $description,
        private readonly ?array  $hallImages,
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
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return array|null
     */
    public function getHallImages(): ?array
    {
        return $this->hallImages;
    }
}
