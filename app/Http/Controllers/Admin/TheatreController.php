<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Theatres\SearchTheatreDTO;
use App\Http\Requests\Admin\Theatres\SearchRequest;
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
    public function index(SearchRequest $request)
    {
        $authUser = auth()->user();
        $searchTern = $request->input('search');

        $searchTheatreDTO = new SearchTheatreDTO(
            producer: $authUser,
            searchTerm: $searchTern,
        );

        $theatres = $this->cinemaService->getCinemasWithHallsPaginated($searchTheatreDTO);

        return view('admin.pages.theatres.theatres-information', compact('theatres'));
    }
}
