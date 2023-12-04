<?php

namespace App\Http\Controllers\Admin;

use App\Models\Movie;
use App\Services\MovieService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class MovieController extends BaseAdminController
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(MovieService $movieService)
    {
        $movies = $movieService->getAllMovies();

        return view('admin.pages.movies.movies-information', compact('movies'));
    }

    /**
     * Displays the movie information page.
     *
     * @param Movie $movie
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show(Movie $movie)
    {
        return view('public.pages.movie', compact('movie'));
    }
}
