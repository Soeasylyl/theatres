<?php

namespace App\Repositories;

use App\DTO\Theatres\CreateTheatreDTO;
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
     * Creates a new theater based on data from the CreateTheatreDTO object and binds the specified user to it.
     *
     * @param CreateTheatreDTO $dto
     * @return Cinema
     */
    public function createTheatreAndAttachUser(CreateTheatreDTO $dto): Cinema
    {
        $cinema = Cinema::create([
            'name' => $dto->getName(),
            'address' => $dto->getAddress(),
            'description' => $dto->getDescription(),
        ]);

        $cinema->users()->attach($dto->getUser()->id);

        return $cinema;
    }
}
