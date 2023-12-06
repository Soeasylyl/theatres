<?php

namespace App\Repositories;

use App\DTO\Theatres\CreateTheatreDTO;
use App\DTO\Theatres\UpdateTheatreDTO;
use App\Models\Cinema;
use App\Models\User;
use App\Repositories\Interfaces\TheatreRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TheatreRepository implements TheatreRepositoryInterface
{
    /**
     * Obtaining information about all users except authorized and super administrator
     *
     * @return LengthAwarePaginator
     */
    public function getCinemasPaginateList(): LengthAwarePaginator
    {
        return Cinema::paginate(config('app.pagination_limit'));
    }

    /**
     * Returns a paginated list of cinemas with screens.
     *
     * @param string|null $searchTerm
     * @param array|null $relations
     * @return LengthAwarePaginator
     */
    public function getTheatresPaginateList(?string $searchTerm, ?array $relations = []): LengthAwarePaginator
    {
        return Cinema::with($relations)
            ->where('name', 'ilike', "%$searchTerm%")
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
    public function getFilteredTheatresByProducer(User $authUser, ?string $searchTerm, ?array $relations = []): LengthAwarePaginator
    {
        return $authUser->cinemas()
            ->with($relations)
            ->where('name', 'ilike', "%$searchTerm%")
            ->paginate(config('app.pagination_limit'));
    }

    /**
     * Creates a new theater based on data from the CreateTheatreDTO object.
     *
     * @param CreateTheatreDTO $dto
     * @return Cinema
     */
    public function createTheatre(CreateTheatreDTO $dto): Cinema
    {
        return Cinema::create([
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
     * @return Cinema
     */
    public function getTheatreByIdOrFail(int $theatreId, ?array $relations = []): Cinema
    {
        return Cinema::with($relations)->findOrFail($theatreId);
    }

    /**
     *  Update the information of a cinema (theatre) entity based on the provided UpdateTheatreDTO.
     *
     * @param Cinema $theatre
     * @param UpdateTheatreDTO $dto
     * @return Cinema
     */
    public function updateTheatreInfo(Cinema $theatre, UpdateTheatreDTO $dto): Cinema
    {
        $theatre->update([
            'name' => $dto->getName(),
            'description' => $dto->getDescription(),
            'address' => $dto->getAddress(),
        ]);

        return $theatre;
    }
}
