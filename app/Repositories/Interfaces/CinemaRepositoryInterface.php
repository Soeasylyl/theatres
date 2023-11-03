<?php

namespace App\Repositories\Interfaces;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface CinemaRepositoryInterface
{
    /**
     * Get all cinemas
     *
     * @return LengthAwarePaginator
     */
    public function getCinemasPaginateList(): LengthAwarePaginator;

    /**
     * Receives information about cinemas with halls and seats.
     *
     * @return Collection
     */
    public function getCinemasWithHallsAndSeats(): Collection;

    /**
     * Returns a paginated list of cinemas with screens.
     *
     * @return LengthAwarePaginator
     */
    public function getCinemasWithHallsPaginated(): LengthAwarePaginator;
}
