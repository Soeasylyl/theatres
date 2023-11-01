<?php

namespace App\Http\Controllers\public;


use App\Repositories\Interfaces\CinemaRepositoryInterface;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use App\Services\MovieService;
use Illuminate\Support\Carbon;

class HomeController extends BasePublicController
{
    public function __construct(
        private readonly MovieService $movieService,
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
        $movies = $this->movieService->getRandomMoviesWithScreenings();

        return view('public.pages.home', compact('movies'));
    }
}
