<?php

namespace App\Services;

use App\DTO\Movies\CreateMovieDTO;
use App\DTO\Movies\UpdateMovieDTO;
use App\DTO\Movies\SearchMovieDTO;
use App\Models\Movie;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class MovieService
{
    public function __construct(
        private readonly MovieRepositoryInterface $movieRepository,
    )
    {
    }

    /**
     * Retrieve a list of random movies with upcoming screenings.
     *
     * @return array
     */
    public function getRandomMoviesWithScreenings(): array
    {
        $currentDateTime = Carbon::now();

        $movies = $this->movieRepository->getRandomMoviesWithScreenings(
            currentDateTime: $currentDateTime,
            limit: 10,
            relations: [
                'genres',
                'poster',
                'frames',
                'medias',
            ]);

        return compact('movies');
    }

    /**
     * Returns a paginated list of all cinemas with auditoriums.
     *
     * @param SearchMovieDTO $dto
     * @return LengthAwarePaginator
     */
    public function getAllMovies(SearchMovieDTO $dto): LengthAwarePaginator
    {
        return $this->movieRepository->getMoviesPaginatedList(searchTern: $dto->getSearchTerm());
    }

    /**
     * Update the movie information based on the provided DTO, including media files.
     *
     * @param UpdateMovieDTO $dto
     * @return Movie
     * @throws \Exception
     */
    public function updateMovie(UpdateMovieDTO $dto): Movie
    {
        $movie = $this->movieRepository->getMovieByIdOrFail(
            movieId: $dto->getMovieId(),
            relations: ['medias'],
        );

        try {
            $this->movieRepository->updateMovieInfo(
                movie: $movie,
                dto: $dto,
            );

            if ($dto->getMoviePoster() !== null) {
                $movie->deleteMedia('poster');
                $movie->saveFile(
                    file: $dto->getMoviePoster(),
                    collectionName: 'poster'
                );
            }

            if ($dto->getMovieFrames() !== null) {
                $movie->deleteMedia('frames');
                $movie->saveMultipleFiles(
                    mediaFiles: $dto->getMovieFrames(),
                    collectionName: 'frames'
                );
            }
        } catch (\Exception $e) {
            Log::error("Failed to save poster or frames: {$e->getMessage()} movie id: {$movie->id}");

            throw $e;
        }
        return $movie;
    }

    /**
     * Create and Save Movie with Media Attachments
     *
     * @param CreateMovieDTO $dto
     * @return Movie
     * @throws \Throwable
     */
    public function createAndSaveMovieWithMedia(CreateMovieDTO $dto): Movie
    {
        $movie = $this->movieRepository->createMovie(dto: $dto);

        try {
            $movie->saveFile(
                file: $dto->getMoviePoster(),
                collectionName: 'poster'
            );
            $movie->saveMultipleFiles(
                mediaFiles: $dto->getMovieFrames(),
                collectionName: 'frames'
            );
        } catch (\Throwable $e) {
            Log::error("Failed to save poster or frames: {$e->getMessage()} movie id: {$movie->id}");

            throw $e;
        }

        return $movie;
    }

    /**
     * Delete a movie
     *
     * @param int $movieId
     * @return void
     * @throws \Exception
     */
    public function deleteMovie(int $movieId): void
    {
        $movie = $this->movieRepository->getMovieByIdOrFail(movieId: $movieId);

        try {
            $movie->deleteMedia('poster', 'frames');
            $movie->delete();
        } catch (\Exception $e) {
            Log::error("Failed to delete movie: {$e->getMessage()}. Movie ID: {$movie->id}");

            throw $e;
        }
    }
}
