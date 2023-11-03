<?php

namespace App\Services;

use App\Repositories\Interfaces\MovieRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;


class MovieService
{
    public function __construct(private readonly MovieRepositoryInterface $movieRepository)
    {
    }

    /**
     * Retrieve a list of random movies with upcoming screenings.
     *
     * @return Collection
     */
    public function getRandomMoviesWithScreenings(): Collection
    {
        $currentDateTime = Carbon::now();

        return $this->movieRepository->getRandomMoviesWithScreenings($currentDateTime, 10);
    }

    /**
     * Returns a paginated list of all cinemas with auditoriums.
     *
     * @return LengthAwarePaginator
     */
    public function getAllMovies():  LengthAwarePaginator
    {
        return $this->movieRepository->getMoviesPaginatedList();
    }
}
