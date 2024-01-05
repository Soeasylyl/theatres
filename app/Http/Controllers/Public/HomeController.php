<?php

namespace App\Http\Controllers\Public;

use App\DTO\Theatres\FilterTheatreDTO;
use App\Models\Movie;
use App\Services\MovieService;
use App\Services\TheatreService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

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
     * @param TheatreService $theatreService
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show(
        Movie          $movie,
        TheatreService $theatreService,
    )
    {
        $filterTheatreDto = new FilterTheatreDTO(
            movie: $movie,
        );

        $theatres = $theatreService->getFilteredTheatersWithPaginateList($filterTheatreDto);

        return view('public.pages.movie', compact(
            'movie',
            'theatres'
        ));
    }

    public function getScreenings(
        Request        $request,
        Movie          $movie,
        TheatreService $theatreService,
    )
    {
        $filterTheatreDto = new FilterTheatreDTO(
            movie: $movie,
            theatreId: $request->input('theatre_id'),
            date: $request->input('date', now()),
            timeZone: $request->input('timeZone'),
        );

        $theatres = $theatreService->getFilteredTheatersWithPaginateList($filterTheatreDto);

        return response()->json([
            'htmlClients' => view(
                'public.partials.theatre_template',
                compact('theatres'))->render(),
        ]);
    }
}
