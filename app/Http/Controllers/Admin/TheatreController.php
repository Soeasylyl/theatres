<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cinema;

class TheatreController extends BaseAdminController
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
    // Displaying information about all cinemas
    public function index()
    {
        $theatres = Cinema::withCount('halls')->get();

        return view('admin.pages.theatres.theatres', compact('theatres'));
    }
}
