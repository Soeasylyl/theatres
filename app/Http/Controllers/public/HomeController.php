<?php

namespace App\Http\Controllers\public;


use App\Repositories\Interfaces\CinemaRepositoryInterface;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use Illuminate\Support\Carbon;

class HomeController extends BasePublicController
{
    public function __construct(
        private readonly MovieRepositoryInterface  $movieRepository,
        private readonly CinemaRepositoryInterface $cinemaRepository
    )
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $currentDateTime = Carbon::now();
        $movies = $this->movieRepository->getRandomMoviesWithScreenings($currentDateTime, 10);
        $cinemas = $this->cinemaRepository->getCinemasPaginateList();  //// потом удалю когда придумаю как и куда выводить кинотеатры

        return view('public.pages.home', compact('movies', 'cinemas'));
    }
}
