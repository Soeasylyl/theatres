<?php

namespace App\Services;

use App\Enums\RolesUsersEnum;
use App\Models\Cinema;
use App\Models\User;
use App\Repositories\Interfaces\CinemaRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;


class CinemaService
{
    public function __construct(
        private readonly CinemaRepositoryInterface $cinemaRepository)
    {
    }

    /**
     * Getting all cinemas PaginateList
     *
     * @return LengthAwarePaginator
     */
    public function getPaginatedCinemasList(): LengthAwarePaginator
    {
        return $this->cinemaRepository->getCinemasPaginateList();
    }

    /**
     * Returns a paginated list of cinemas with screens.
     *
     * @return LengthAwarePaginator
     */
    public function getCinemasWithHallsPaginated(): LengthAwarePaginator
    {
        return $this->cinemaRepository->getCinemasPaginateList();
    }
}
