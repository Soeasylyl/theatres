<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Movies\SearchMovieDTO;
use App\Http\Requests\Admin\Movies\SearchRequest;
use App\Http\Requests\Admin\Movies\UpdateMovieRequest;
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
     * @param UpdateMovieRequest $request
     * @return RedirectResponse
     */
    public function update(UpdateMovieRequest $request)
    {


        return redirect()->route('admin.pages.movies.edit')->with('message', 'Информация успешно обновлена');
    }

    public function show()
    {
        return view('admin.pages.movies.add');
    }
}
