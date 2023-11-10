<?php

namespace App\Http\Controllers\Admin;

use App\Services\CinemaService;
use Illuminate\Contracts\Support\Renderable;

class TheatreController extends BaseAdminController
{
    public function __construct( private readonly CinemaService $cinemaService)
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $theatres = $this->cinemaService->getCinemasWithHallsPaginated();

        return view('admin.pages.theatres.theatres', compact('theatres'));
    }
}
