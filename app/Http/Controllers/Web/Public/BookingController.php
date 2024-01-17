<?php

namespace App\Http\Controllers\Web\Public;

use App\Models\Movie;
use App\Repositories\MovieRepository;
use App\Services\MovieService;
use App\Services\ScreeningService;

class BookingController extends BasePublicController
{
    public function create(
        int            $movieId,
        int              $screeningId,
        ScreeningService $screeningService,
        MovieRepository $movieRepository,
    )
    {
        $movie = $movieRepository->getMovieByIdOrFail($movieId);
        $screening = $screeningService->getScreening($screeningId);

        return view('public.pages.payment', [
            'movie' => $movie,
            'screening' => $screening,
            ]);
    }
}
