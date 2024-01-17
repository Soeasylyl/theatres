<?php

namespace App\Http\Controllers\Ajax\Public;

use App\DTO\Screening\TimeConversionScreeningDTO;
use App\DTO\Theatres\FilterTheatreDTO;
use App\Http\Controllers\Ajax\Public\BasePublicController;
use App\Http\Requests\Public\ajaxGetScreeningsRequest;
use App\Models\Movie;
use App\Services\ScreeningService;
use App\Services\TheatreService;
use Illuminate\Http\JsonResponse;

class HomeController extends BasePublicController
{
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
