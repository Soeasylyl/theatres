<?php

namespace App\Http\Controllers\Ajax\Admin;

use App\DTO\Movies\SearchMovieDTO;
use App\Http\Controllers\Ajax\Admin\BaseAdminController;
use App\Http\Requests\Admin\Movies\SearchRequest;
use App\Services\MovieService;
use Illuminate\Http\JsonResponse;

class MovieController extends BaseAdminController
{
    /**
     *  Get movies based on search criteria.
     *
     * @param SearchRequest $request
     * @param MovieService $movieService
     * @return JsonResponse
     */
    public function getMovies(
        SearchRequest $request,
        MovieService  $movieService,
    )
    {
        $searchMovieDTO = new SearchMovieDTO(
            searchTerm: $request->input('search'),
        );

        try {
            $movies = $movieService->getAllMovies($searchMovieDTO);

            return response()->json([
                'status' => true,
                'movies' => $movies,
            ]);
        } catch (\Throwable $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
