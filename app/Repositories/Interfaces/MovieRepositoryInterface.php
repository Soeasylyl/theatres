<?php

namespace App\Repositories\Interfaces;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

interface MovieRepositoryInterface
{
    /**
     * Get all movies
     *
     * @param string|null $searchTern
     * @return LengthAwarePaginator
     */
    public function getMoviesPaginatedList(?string $searchTern): LengthAwarePaginator;

    /**
     * @param Carbon $currentDateTime
     * @param int|null $limit
     * @param array $relations
     * @return Collection
     */
    public function getRandomMoviesWithScreenings(Carbon $currentDateTime, int $limit = null, array $relations = []): Collection;
}
