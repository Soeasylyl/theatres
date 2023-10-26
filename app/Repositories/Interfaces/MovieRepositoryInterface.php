<?php

namespace App\Repositories\Interfaces;


use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface MovieRepositoryInterface
{
    /**
     * Get all movies
     *
     * @return LengthAwarePaginator
     */
    public function getAllMovies(): LengthAwarePaginator;

    /**
     * @param $currentDateTime
     * @return mixed
     */
    public function getRandomMoviesWithScreenings($currentDateTime): Collection;
}
