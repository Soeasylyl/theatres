<?php

namespace App\Http\Controllers\Public;

use App\Models\Movie;
use App\Services\MovieService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

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
        $data = $this->movieService->getRandomMoviesWithScreenings();

        return view('public.pages.home', $data);
    }

    /**
     * Displays the movie information page.
     *
     * @param Movie $movie
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show(Movie $movie)
    {
        return view('admin.pages.users.edit', compact('movie'));
    }
}
