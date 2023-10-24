<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Repositories\Interfaces\MovieRepositoryInterface;


class MovieRepository implements MovieRepositoryInterface
{
    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator|\LaravelIdea\Helper\App\Models\_IH_Movie_C|\Illuminate\Contracts\Pagination\LengthAwarePaginator|Movie[]
     */
    public function getAllMovies(): array|\Illuminate\Pagination\LengthAwarePaginator|\LaravelIdea\Helper\App\Models\_IH_Movie_C|\Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return Movie::paginate(10);
    }

    public function getRandomMoviesWithScreenings($currentDateTime): \Illuminate\Database\Eloquent\Collection
    {
        return Movie::with(['screenings' => function ($query) use ($currentDateTime) {
            $query->where('start_at', '>=', $currentDateTime)->orderBy('start_at', 'asc')->limit(1);
        }])->whereHas('screenings', function ($query) use ($currentDateTime) {
                $query->where('start_at', '>=', $currentDateTime);
            })->inRandomOrder()
            ->limit(10)
            ->get();
    }
}
