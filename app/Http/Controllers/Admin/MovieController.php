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
     * @param MovieService $movieService
     */
    public function __construct(private readonly MovieService $movieService)
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(SearchRequest $request)
    {
        $searchTern = $request->input('search');

        $searchMovieDTO = new SearchMovieDTO(
            searchTerm: $searchTern,
        );

        $movies = $this->movieService->getAllMovies(dto: $searchMovieDTO);

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
     * @return RedirectResponse
     */
    public function update(MovieRequest $request, int $movieId)
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
            $this->movieService->updateMovie(dto: $updateMovieDTO);

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
    public function show()
    {
        return view('admin.pages.movies.add');
    }

    /**
     *  Create new movie
     *
     * @param MovieRequest $request
     * @return RedirectResponse
     */
    public function create(MovieRequest $request)
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
            $this->movieService->createAndSaveMovieWithMedia(dto: $createMovieDTO);

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
     * @return RedirectResponse
     */
    public function delete(int $id)
    {
        $deleteMovieDto = new DeleteMovieDTO(
            movieId: $id,
        );

        try {
            $this->movieService->deleteMovie(movieId: $deleteMovieDto->getMovieId());

            return redirect()->route('movies')->with('successMessages', 'Фильм успешно удален.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
