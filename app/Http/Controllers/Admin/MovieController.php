<?php

namespace App\Http\Controllers\Admin;

use App\Models\Movie;

class MovieController extends BaseAdminController
{
    public function __construct()
    {
        $this->middleware('auth')->only('index');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // Display information about all films
    public function index()
    {
        $movies = Movie::all();

        return view('admin.pages.movies.movies-information',compact('movies'));
    }

    public function show( $slug)
    {
        $movie = Movie::where('slug', $slug)->firstOrFail();
        return view('public.pages.movie', compact('movie'));
    }
}
