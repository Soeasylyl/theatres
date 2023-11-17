<?php

namespace App\Services;

use App\Repositories\Interfaces\MovieRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\MorphMany;
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
     * @return array
     */
    public function getRandomMoviesWithScreenings(): array
    {
        $currentDateTime = Carbon::now();

        $movies = $this->movieRepository->getRandomMoviesWithScreenings(
            currentDateTime: $currentDateTime,
            limit: 10,
            relations: [
                'genres',
                'poster',
                'frames',
                'medias',
            ]);

        return compact('movies');
    }

    /**
     * Returns a paginated list of all cinemas with auditoriums.
     *
     * @return LengthAwarePaginator
     */
    public function getAllMovies(): LengthAwarePaginator
    {
        return $this->movieRepository->getMoviesPaginatedList();
    }
}
