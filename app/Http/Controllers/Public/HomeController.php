<?php

namespace App\Http\Controllers\Public;

use App\DTO\Screening\TimeConversionScreeningDTO;
use App\DTO\Theatres\FilterTheatreDTO;
use App\Http\Requests\Public\ajaxGetScreeningsRequest;
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

    /**
     *  Retrieves and returns filtered lists of movie theaters with showings for the movie shown.
     *
     * @param ajaxGetScreeningsRequest $request
     * @param Movie $movie
     * @param TheatreService $theatreService
     * @return JsonResponse
     */
    public function getScreenings(
        ajaxGetScreeningsRequest $request,
        Movie                    $movie,
        TheatreService           $theatreService,
    )
    {
        $filterTheatreDto = new FilterTheatreDTO(
            movie: $movie,
            theatreId: $request->input('theatre_id'),
            date: $request->input('date', now()),
            timeZone: $request->input('timeZone'),
            startTime: $request->input('startTime'),
            endTime: $request->input('endTime'),
        );

        try {
            $theatres = $theatreService->getFilteredTheatersWithPaginateList($filterTheatreDto);

            return response()->json([
                'htmlClients' => view(
                    'public.partials.theatre_template',
                    compact('theatres', 'movie'))->render(),
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], 500);
        }
    }

    public function showHall(
        Movie $movie,
        int   $screeningId,
        ScreeningRepositoryInterface $screeningRepository
    )
    {
        $screening = $screeningRepository->getScreeningByIdOrFail(
            screeningId: $screeningId,
            relations: ['movie', 'bookings','hall.theatre'],
        );

        return view('public.pages.booking', compact(
            'movie',
            'screening',
        ));
    }

    /**
     *  Get the start and end time of a movie screening in a time zone-converted format.
     *
     * @param Movie $movie
     * @param int $screeningId
     * @param ScreeningService $screeningService
     * @return JsonResponse
     */
    public function getScreeningsTime(
        Movie            $movie,
        int              $screeningId,
        ScreeningService $screeningService,
    ): JsonResponse
    {
        $timeConversionScreeningDto = new TimeConversionScreeningDTO(
            movie: $movie,
            screeningId: $screeningId,
        );

        try {
            $data = $screeningService->getStartAndEndTimeMovieScreening($timeConversionScreeningDto);

            return response()->json([
                'status' => true,
                'sessionStart' => $data['sessionStart'],
                'sessionEnd' => $data['sessionEnd'],
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => false,
                'error' => $exception->getMessage(),
            ], 500);
        }
    }
}
