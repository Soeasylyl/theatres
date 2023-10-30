<?php

namespace App\Http\Controllers\Admin;

use App\Models\Movie;
use App\Repositories\Interfaces\MovieRepositoryInterface;

class MovieController extends BaseAdminController
{
    public function __construct(private readonly MovieRepositoryInterface $movieRepository)
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // Display information about all films
    public function index()
    {
        $movies = $this->movieRepository->getMoviesPaginatedList();

        return view('admin.pages.movies.movies-information', compact('movies'));
    }

    public function show(Movie $movie)
    {
        return view('public.pages.movie', compact('movie'));
    }
}
