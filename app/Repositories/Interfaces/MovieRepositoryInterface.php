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
     * @return LengthAwarePaginator
     */
    public function getMoviesPaginatedList(?string $searchTern): LengthAwarePaginator;

    /**
     * @param Carbon $currentDateTime
     * @param int|null $limit
     * @param array $relations
     * @return Collection
     */
    public function getRandomMoviesWithScreenings(Carbon $currentDateTime, int $limit = null, array $relations = []): Collection;

    /**
     * Retrieve a movie with specified relationships or throw an exception if not found.
     *
     * @param array|null $relations The relationships to eager load.
     * @param int $movieId The ID of the movie to retrieve.
     * @return Movie The retrieved movie with specified relationships.
     * @throws ModelNotFoundException If the movie with the given ID is not found.
     */
    public function getMovieWithRelationsFindOrFail(?array $relations, int $movieId): Movie;

    /**
     * Update the information of a movie with the provided data.
     *
     * @param Movie $movie The movie model to be updated.
     * @param UpdateMovieDTO $dto The data transfer object containing the updated movie information.
     * @param string $slug The unique slug for the movie.
     * @return Movie The updated movie model.
     */
    public function updateMovieInfo(Movie $movie, UpdateMovieDTO $dto, string $slug): Movie;

    /**
     * Count the number of movies with a given slug, excluding the movie with the specified ID.
     *
     * @param string $slug The slug to check.
     * @param int $id The ID of the movie to exclude from the count.
     * @return int The count of movies with the specified slug, excluding the given ID.
     */
    public function countMoviesWithSlugExcludingId(string $slug, int $id): int;

    /**
     * Creates a new movie record in the database based on the provided CreateMovieDTO and slug.
     *
     * @param CreateMovieDTO $dto The data transfer object containing movie information.
     * @param string $slug The unique slug for the movie.
     * @return Movie The newly created movie instance.
     */
    public function createMovie(CreateMovieDTO $dto, string $slug): Movie;
}
