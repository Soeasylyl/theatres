<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Movies\CreateMovieDTO;
use App\DTO\Movies\DeleteMovieDTO;
use App\DTO\Movies\UpdateMovieDTO;
use App\DTO\Movies\SearchMovieDTO;
use App\Http\Requests\Admin\Movies\SearchRequest;
use App\Http\Requests\Admin\Movies\MovieRequest;
use App\Models\Movie;
use App\Services\MovieService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MovieController extends BaseAdminController
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(SearchRequest $request, MovieService $movieService)
    {
        $searchTern = $request->input('search');

        $searchMovieDTO = new SearchMovieDTO(
            searchTerm: $searchTern,
        );

        $movies = $movieService->getAllMovies(dto: $searchMovieDTO);

        return view('admin.pages.movies.movies', compact('movies', 'searchTern'));
    }

    /**
     * Displays the movie information page.
     *
     * @param Movie $movie
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function edit(Movie $movie)
    {
        return view('admin.pages.movies.edit', compact('movie'));
    }

    /**
     * Updating information for the selected Movie
     *
     * @param MovieRequest $request
     * @param int $movieId
     * @param MovieService $movieService
     * @return RedirectResponse
     */
    public function update(
        MovieRequest $request,
        int          $movieId,
        MovieService $movieService)
    {
        $updateMovieDTO = new UpdateMovieDTO(
            movieId: $movieId,
            name: $request->input('name'),
            dateStart: $request->input('date_start'),
            sessionDuration: $request->input('session_duration'),
            rating: $request->input('rating'),
            ageLimit: $request->input('age_limit'),
            description: $request->input('description'),
            moviePoster: $request->file('poster'),
            movieFrames: $request->file('frames'),
        );

        try {
            $movieService->updateMovie(dto: $updateMovieDTO);

            return redirect()
                ->route('movies')
                ->with('successMessages', 'Информация о фильме ' . $updateMovieDTO->getName() . ' успешно обновлена');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function create()
    {
        return view('admin.pages.movies.add');
    }

    /**
     *  Create new movie
     *
     * @param MovieRequest $request
     * @param MovieService $movieService
     * @return RedirectResponse
     */
    public function store(MovieRequest $request, MovieService $movieService)
    {
        $createMovieDTO = new CreateMovieDTO(
            name: $request->input('name'),
            dateStart: $request->input('date_start'),
            sessionDuration: $request->input('session_duration'),
            rating: $request->input('rating'),
            ageLimit: $request->input('age_limit'),
            description: $request->input('description'),
            moviePoster: $request->file('poster'),
            movieFrames: $request->file('frames'),
        );

        try {
            $movieService->createAndSaveMovieWithMedia(dto: $createMovieDTO);

            return redirect()
                ->route('movies')
                ->with('successMessages', 'Фильм ' . $createMovieDTO->getName() . ' успешно добавлен');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete Movie
     * Attempts to delete a movie based on the provided movie ID.
     *
     * @param int $id
     * @param MovieService $movieService
     * @return RedirectResponse
     */
    public function destroy(int $id, MovieService $movieService)
    {
        $deleteMovieDto = new DeleteMovieDTO(
            movieId: $id,
        );

        try {
            $movieService->deleteMovie(movieId: $deleteMovieDto->getMovieId());

            return redirect()->route('movies')->with('successMessages', 'Фильм успешно удален.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
