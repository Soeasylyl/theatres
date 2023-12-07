<?php

namespace App\Repositories\Interfaces;

use App\DTO\Halls\CreateHallDTO;
use App\Models\Cinema;
use App\Models\Hall;

interface HallRepositoryInterface
{
    /**
     * Create a new hall within the specified cinema (theatre) based on the provided DTO.
     *
     * @param Cinema $theatre
     * @param CreateHallDTO $dto
     * @return Hall
     */
    public function createHall(Cinema $theatre, CreateHallDTO $dto): Hall;

    /**
     * Retrieve a hall by its ID, eager loading specified relationships if provided, or fail if not found.
     *
     * @param int $hallId
     * @param array|null $relations
     * @return Hall
     */
    public function getHallByIdOrFail(int $hallId, ?array $relations = []): Hall;
}
