<?php

namespace App\Http\Controllers\Web\Public;

use App\DTO\Screening\TimeConversionScreeningDTO;
use App\DTO\Theatres\FilterTheatreDTO;
use App\Http\Requests\Public\AjaxGetScreeningsRequest;
use App\Models\Movie;
use App\Repositories\Interfaces\ScreeningRepositoryInterface;
use App\Services\MovieService;
use App\Services\ScreeningService;
use App\Services\TheatreService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

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
     * @throws \Exception
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

    public function showHall(
        Movie $movie,
        int   $screeningId,
        ScreeningRepositoryInterface $screeningRepository
    )
    {
        $screening = $screeningRepository->getScreeningByIdOrFail(
            screeningId: $screeningId,
            relations: ['movie', 'bookings','hall.theatre.seatTypes'],
        );

        return view('public.pages.booking', compact(
            'movie',
            'screening',
        ));
    }
}
