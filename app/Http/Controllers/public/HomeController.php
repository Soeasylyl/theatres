<?php

namespace App\Http\Controllers\public;


use App\Services\MovieService;
use Illuminate\Contracts\Support\Renderable;

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
     * @return Renderable
     */
    public function index()
    {
        $movies = $this->movieService->getRandomMoviesWithScreenings();

        return view('public.pages.home', compact('movies'));
    }
}
