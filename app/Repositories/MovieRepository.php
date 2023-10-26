<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;


class MovieRepository implements MovieRepositoryInterface
{
    /**
     * @return LengthAwarePaginator
     */
    public function getAllMovies(): LengthAwarePaginator
    {
        return Movie::paginate(10);
    }

    /**
     * @param $currentDateTime
     * @return Collection
     */
    public function getRandomMoviesWithScreenings($currentDateTime): Collection
    {
        return Movie::query()
            ->with(['screenings' => function ($query) use ($currentDateTime) {
                $query->where('start_at', '>=', $currentDateTime)->orderBy('start_at', 'asc')->limit(1);
            }])
            ->whereHas('screenings', function ($query) use ($currentDateTime) {
                $query->where('start_at', '>=', $currentDateTime);
            })
            ->inRandomOrder()
            ->limit(10)
            ->get();
    }
}
