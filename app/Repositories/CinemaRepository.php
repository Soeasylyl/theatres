<?php

namespace App\Repositories;



use App\Models\Cinema;
use App\Repositories\Interfaces\CinemaRepositoryInterface;


class CinemaRepository implements CinemaRepositoryInterface
{
    /**
     * Obtaining information about all users except authorized and super administrator
     *
     * @return array|\Illuminate\Pagination\LengthAwarePaginator|\LaravelIdea\Helper\App\Models\_IH_Cinema_C|\Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllCinemas(): array|\Illuminate\Pagination\LengthAwarePaginator|\LaravelIdea\Helper\App\Models\_IH_Cinema_C|\Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
         return Cinema::paginate(10);
    }
}
