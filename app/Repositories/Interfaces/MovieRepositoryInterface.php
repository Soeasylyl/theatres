<?php

namespace App\Repositories\Interfaces;


use App\DTO\Movies\CreateMovieDTO;
use App\DTO\Movies\UpdateMovieDTO;
use App\Models\Movie;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;

interface MovieRepositoryInterface
{
    /**
     * Get all movies
     *
     * @param string|null $searchTern
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function getMoviesPaginatedList(
        ?string $searchTern = null,
        array   $columns = ['*'],
    ): LengthAwarePaginator;

    /**
     * @param Carbon $currentDateTime
     * @param int|null $limit
     * @param array $relations
     * @return Collection
     */
    public function getRandomMoviesWithScreenings(
        Carbon $currentDateTime,
        int $limit = null,
        array $relations = [],
    ): Collection;

    /**
     * Retrieve a movie with specified relationships or throw an exception if not found.
     *
     * @param array|null $relations The relationships to eager load.
     * @param int $movieId The ID of the movie to retrieve.
     * @return Movie The retrieved movie with specified relationships.
     * @throws ModelNotFoundException If the movie with the given ID is not found.
     */
    public function getMovieByIdOrFail(int $movieId, ?array $relations = []): Movie;

    /**
     * Update the information of a movie with the provided data.
     *
     * @param Movie $movie The movie model to be updated.
     * @param UpdateMovieDTO $dto The data transfer object containing the updated movie information.
     * @return Movie The updated movie model.
     */
    public function updateMovieInfo(Movie $movie, UpdateMovieDTO $dto): Movie;

    /**
     * Creates a new movie record in the database based on the provided CreateMovieDTO and slug.
     *
     * @param CreateMovieDTO $dto The data transfer object containing movie information.
     * @return Movie The newly created movie instance.
     */
    public function createMovie(CreateMovieDTO $dto): Movie;
}
