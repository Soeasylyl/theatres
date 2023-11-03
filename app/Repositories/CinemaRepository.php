<?php

namespace App\Repositories;



use App\Models\Cinema;
use App\Repositories\Interfaces\CinemaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;


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
     * @return LengthAwarePaginator
     */
    public function getCinemasWithHallsPaginated(): LengthAwarePaginator
    {
        return Cinema::with('halls')->paginate(config('app.pagination_limit'));
    }
}
