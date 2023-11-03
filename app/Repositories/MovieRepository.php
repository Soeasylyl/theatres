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
     * @return Collection
     */
    public function getRandomMoviesWithScreenings(Carbon $currentDateTime, int $limit = null): Collection
    {
        return Movie::with([
                'genres',
                'medias' => function (MorphMany $query) {
                    $query->where(function (Builder $q) {
                        $q->whereIn('collection', ['frames', 'poster']);
                    });
                },
                'screenings' => function (HasMany $query) use ($currentDateTime) {
                    $query->whereDate('start_at', '>=', $currentDateTime)
                          ->orderBy('start_at')
                          ->limit(1);
                },
            ])
            ->has('screenings')
            ->inRandomOrder()
            ->when($limit !== null, fn(Builder $query) => $query->limit($limit))
            ->get();
    }
}
