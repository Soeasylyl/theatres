<?php

namespace App\Repositories;

use App\DTO\Theatres\CreateTheatreDTO;
use App\DTO\Theatres\UpdateTheatreDTO;
use App\Models\Theatre;
use App\Models\User;
use App\Repositories\Interfaces\TheatreRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class TheatreRepository implements TheatreRepositoryInterface
{
    /**
     * Obtaining information about all users except authorized and super administrator
     *
     * @param array|null $relations
     * @return LengthAwarePaginator
     */
    public function getCinemasPaginateList(?array $relations = []): LengthAwarePaginator
    {
        return Theatre::with($relations)->paginate(config('app.pagination_limit'));
    }

    /**
     * Returns a paginated list of cinemas with screens.
     *
     * @param string|null $searchTerm
     * @param array|null $relations
     * @return LengthAwarePaginator
     */
    public function getTheatresPaginateList(?string $searchTerm = null, ?array $relations = []): LengthAwarePaginator
    {
        return Theatre::with($relations)
            ->when(!is_null($searchTerm), function (Builder $builder) use ($searchTerm) {
                $builder->where('name', 'ilike', "%$searchTerm%");
            })
            ->paginate(config('app.pagination_limit'));
    }

    /**
     * Gets a filtered list of movie theaters to which the specified user belongs.
     *
     * @param User $authUser
     * @param string|null $searchTerm
     * @param array|null $relations
     * @return LengthAwarePaginator
     */
    public function getFilteredTheatresByProducer(User $authUser, ?string $searchTerm = null, ?array $relations = []): LengthAwarePaginator
    {
        return $authUser->theatres()
            ->with($relations)
            ->when(!is_null($searchTerm), function (Builder $builder) use ($searchTerm) {
                $builder->where('name', 'ilike', "%$searchTerm%");
            })
            ->paginate(config('app.pagination_limit'));
    }

    /**
     * Creates a new theater based on data from the CreateTheatreDTO object.
     *
     * @param CreateTheatreDTO $dto
     * @return Theatre
     */
    public function createTheatre(CreateTheatreDTO $dto): Theatre
    {
        return Theatre::create([
            'name' => $dto->getName(),
            'address' => $dto->getAddress(),
            'description' => $dto->getDescription(),
        ]);
    }

    /**
     * Retrieves a theater object by its ID, or throws an exception if the theater is not found.
     *
     * @param int $theatreId
     * @param array|null $relations
     * @return Theatre
     */
    public function getTheatreByIdOrFail(int $theatreId, ?array $relations = []): Theatre
    {
        return Theatre::with($relations)->findOrFail($theatreId);
    }

    /**
     *  Update the information of a cinema (theatre) entity based on the provided UpdateTheatreDTO.
     *
     * @param Theatre $theatre
     * @param UpdateTheatreDTO $dto
     * @return Theatre
     */
    public function updateTheatreInfo(Theatre $theatre, UpdateTheatreDTO $dto): Theatre
    {
        $theatre->update([
            'name' => $dto->getName(),
            'description' => $dto->getDescription(),
            'address' => $dto->getAddress(),
        ]);

        return $theatre;
    }
}
