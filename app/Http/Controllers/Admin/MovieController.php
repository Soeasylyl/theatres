<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;

class MovieController extends BaseAdminController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $movies = Movie::all();

        return view('admin.pages.movies.movies',compact('movies'));

    }

    public function edit($movie)
    {
//        $movies = Movie::findOrFail($movie);
//
//        return view('admin.pages.users.edit',  compact('movies'));
    }
}
