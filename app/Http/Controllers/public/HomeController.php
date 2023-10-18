<?php

namespace App\Http\Controllers\public;



use App\Models\Cinema;
use App\Models\Movie;

class HomeController extends BasePublicController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $movies = Movie::inRandomOrder()->limit(10)->get();
        $cinemas = Cinema::all();

        return view('public.pages.home', compact('movies', 'cinemas'));
    }
}
