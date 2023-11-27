<?php

namespace App\Repositories;

use App\Models\Cinema;
use App\Models\User;
use App\Repositories\Interfaces\CinemaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class CinemaRepository implements CinemaRepositoryInterface
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
     * @param array|null $relations
     * @return LengthAwarePaginator
     */
    public function getFilteredTheatresByProducer(User $authUser, ?array $relations = []): LengthAwarePaginator
    {
        return $authUser->cinemas()->with($relations)->paginate(config('app.pagination_limit'));
    }
}
