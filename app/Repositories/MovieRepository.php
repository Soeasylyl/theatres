<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;


class MovieRepository implements MovieRepositoryInterface
{
    /**
     * @return LengthAwarePaginator
     */
    public function getMoviesPaginatedList(): LengthAwarePaginator
    {
        return Movie::paginate(config('app.pagination_limit'));
    }

    /**
     * @param Carbon $currentDateTime
     * @param int|null $limit
     * @return Collection
     */
    public function getRandomMoviesWithScreenings(Carbon $currentDateTime, int $limit = null): Collection
    {
        $query = Movie::query()
            ->with(['screenings' => function (HasMany $query) use ($currentDateTime) {
                $query->where('start_at', '>=', $currentDateTime)
                      ->orderBy('start_at', 'asc')
                      ->limit(1);
            }])
            ->whereHas('screenings', function (Builder $query) use ($currentDateTime) {
                $query->where('start_at', '>=', $currentDateTime);
            })
            ->inRandomOrder();

        if ($limit !== null) {
            $query->limit($limit);
        }

        return $query->get();
    }
}
