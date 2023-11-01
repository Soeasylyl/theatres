<?php

namespace App\Services;

use App\Repositories\Interfaces\CinemaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class CinemaService
{
    public function __construct(  private readonly CinemaRepositoryInterface $cinemaRepository,)
    {
    }

    /**
     * Getting all cinemas PaginateList
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getPaginatedCinemasList(): LengthAwarePaginator
    {
        return $this->cinemaRepository->getCinemasPaginateList();
    }
}
