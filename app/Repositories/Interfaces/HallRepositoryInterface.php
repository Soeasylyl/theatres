<?php

namespace App\Repositories\Interfaces;

use App\DTO\Halls\CreateHallDTO;
use App\DTO\Halls\UpdateHallDTO;
use App\Models\Theatre;
use App\Models\Hall;
use Illuminate\Database\Eloquent\Collection;

interface HallRepositoryInterface
{
    /**
     * Create a new hall within the specified cinema (theatre) based on the provided DTO.
     *
     * @param Theatre $theatre
     * @param CreateHallDTO $dto
     * @return Hall
     */
    public function createHall(Theatre $theatre, CreateHallDTO $dto): Hall;

    /**
     * Retrieve a hall by its ID, eager loading specified relationships if provided, or fail if not found.
     *
     * @param int $hallId
     * @param array|null $relations
     * @return Hall
     */
    public function getHallByIdOrFail(int $hallId, ?array $relations = []): Hall;

    /**
     * Update the specified hall.
     *
     * @param Hall $hall
     * @param UpdateHallDTO $dto
     * @return bool
     */
    public function updateHall(Hall $hall,UpdateHallDTO $dto): bool;

    /**
     * It turns out the hall object with checking the lighting in the cinema and the restrictions on the type of seats.
     *
     * @param int $seatsTypeId
     * @param int $hallId
     * @param int $theatreId
     * @return Hall
     */
    public function getHallForCreationChecking(
        int $theatreId,
        int $hallId,
        int $seatsTypeId,
    ): Hall;

    /**
     * Retrieves a list of screens for the specified theatre.
     *
     * @param int $theatreId
     * @param array|null $columns
     * @return Collection
     */
    public function getHallsByTheatreId(int $theatreId, ?array $columns = ['*']): Collection;
}
