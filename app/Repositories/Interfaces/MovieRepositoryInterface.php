<?php

namespace App\Repositories\Interfaces;


interface MovieRepositoryInterface
{
    /**
     * Get all movies
     *
     * @return mixed
     */
    public function getAllMovies(): mixed;

    public function getRandomMoviesWithScreenings($currentDateTime);
}
