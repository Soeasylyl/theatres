<?php

namespace App\Repositories;

use App\DTO\Halls\CreateHallDTO;
use App\DTO\Halls\UpdateHallDTO;
use App\Models\Hall;
use App\Models\Theatre;
use App\Repositories\Interfaces\HallRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class HallRepository implements HallRepositoryInterface
{
    /**
     * Create a new hall within the specified cinema (theatre) based on the provided DTO.
     *
     * @param Theatre $theatre
     * @param CreateHallDTO $dto
     * @return Hall
     */
    public function createHall(Theatre $theatre, CreateHallDTO $dto): Hall
    {
        return $theatre->halls()->create([
            'name' => $dto->getName(),
            'description' => $dto->getDescription(),
        ]);
    }

    /**
     * Retrieve a hall by its ID, eager loading specified relationships if provided, or fail if not found.
     *
     * @param int $hallId
     * @param array|null $relations
     * @return Hall
     */
    public function getHallByIdOrFail(int $hallId, ?array $relations = []): Hall
    {
        return Hall::with($relations)->findOrFail($hallId);
    }

    /**
     * Update the specified hall.
     *
     * @param Hall $hall
     * @param UpdateHallDTO $dto
     * @return bool
     */
    public function updateHall(Hall $hall, UpdateHallDTO $dto): bool
    {
        return $hall->update([
            'theatre_id' => $dto->getTheatreId(),
            'name' => $dto->getName(),
            'description' => $dto->getDescription(),
        ]);
    }

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
    ): Hall
    {
        return Hall::query()
            ->whereHas('theatre', function (Builder $builder) use ($seatsTypeId, $theatreId) {
                $builder->where('id', $theatreId)
                        ->whereHas('seatTypes', function (Builder $builder) use ($seatsTypeId) {
                            $builder->where('id', $seatsTypeId);
                        });
            })
            ->findOrFail($hallId);
    }
}
