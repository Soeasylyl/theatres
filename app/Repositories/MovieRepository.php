<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Carbon;

class MovieRepository implements MovieRepositoryInterface
{
    /**
     * Get a paginated list of movies.
     *
     * @return LengthAwarePaginator
     */
    public function getMoviesPaginatedList(): LengthAwarePaginator
    {
        return Movie::paginate(config('app.pagination_limit'));
    }

    /**
     *Get a collection of random movies along with their screenings and related media.
     *
     * @param Carbon $currentDateTime
     * @param int|null $limit
     * @param array|null $relations
     * @return Collection
     */
    public function getRandomMoviesWithScreenings(Carbon $currentDateTime, int $limit = null, ?array $relations = []): Collection
    {
        return Movie::with($relations)
            ->withWhereHas('screenings', function (Builder|HasMany $query) use ($currentDateTime) {
                $query->whereDate('start_at', '>=', $currentDateTime);
            })
            ->inRandomOrder()
            ->when($limit !== null, fn(Builder $query) => $query->limit($limit))
            ->get();
    }
}
