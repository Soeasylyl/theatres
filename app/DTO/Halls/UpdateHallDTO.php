<?php

namespace App\DTO\Halls;

class UpdateHallDTO
{
    /**
     * @param int $theatresId
     * @param int $hallId
     * @param string $name
     * @param string $description
     * @param array $rows
     * @param array|null $hallImages
     */
    public function __construct(
        private readonly int $theatresId,
        private readonly int $hallId,
        private readonly string  $name,
        private readonly string  $description,
        private readonly array  $rows,
        private readonly ?array  $hallImages,
    )
    {
    }

    /**
     * @return int
     */
    public function getTheatresId(): int
    {
        return $this->theatresId;
    }

    /**
     * @return int
     */
    public function getHallId(): int
    {
        return $this->hallId;
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
     * @return array
     */
    public function getRows(): array
    {
        return $this->rows;
    }

    /**
     * @return array|null
     */
    public function getHallImages(): ?array
    {
        return $this->hallImages;
    }
}
