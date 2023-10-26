<?php

namespace App\Http\Controllers\Admin;

use App\Models\Cinema;

class TheatreController extends BaseAdminController
{
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // Displaying information about all cinemas
    public function index()
    {
        // TODO: обратить внимание на withCount, для чего мне оно???
        $theatres = Cinema::withCount('halls')->get();

        return view('admin.pages.theatres.theatres', compact('theatres'));
    }
}
