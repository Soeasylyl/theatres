<?php

namespace App\Services;

use App\Repositories\Interfaces\MovieRepositoryInterface;
use Illuminate\Support\Carbon;


class MovieService
{

    public function __construct(private readonly MovieRepositoryInterface $movieRepository)
    {
    }

    public function getRandomMoviesWithScreenings()
    {
        $currentDateTime = Carbon::now();

        return $this->movieRepository->getRandomMoviesWithScreenings($currentDateTime, 10);
    }
}
