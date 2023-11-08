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
     * @return LengthAwarePaginator
     */
    public function getMoviesPaginatedList(): LengthAwarePaginator;

    /**
     * @param Carbon $currentDateTime
     * @param int|null $limit
     * @param array $values
     * @return Collection
     */
    public function getRandomMoviesWithScreenings(Carbon $currentDateTime, int $limit = null, array $values = []): Collection;
}
