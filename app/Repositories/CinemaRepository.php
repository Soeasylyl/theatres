<?php

namespace App\Repositories;

use App\Models\Cinema;
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
     * @param array|null $relations
     * @return LengthAwarePaginator
     */
    public function getCinemasPaginated(?array $relations = []): LengthAwarePaginator
    {
        return Cinema::with($relations)->paginate(config('app.pagination_limit'));
    }
}
