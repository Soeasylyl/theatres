<?php

namespace App\Http\Controllers\Public;

use App\Models\Movie;
use App\Models\Theatre;
use App\Services\MovieService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function show(Movie $movie)
    {
        $theaters = Theatre::with('halls.screenings')
            ->WithWhereHas('halls.screenings', function (Builder|HasMany $builder) use ($movie) {
                $builder->where('movie_id', $movie->id)
                        ->where('start_at', '>=', now());
            })
            ->paginate(config('app.pagination_limit'));

        return view('public.pages.movie', compact('movie', 'theaters'));
    }
}
