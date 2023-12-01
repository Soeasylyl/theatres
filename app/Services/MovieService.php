<?php

namespace App\Services;

use App\DTO\Movies\CreateMovieDTO;
use App\DTO\Movies\UpdateMovieDTO;
use App\DTO\Movies\SearchMovieDTO;
use App\Models\Movie;
use App\Repositories\Interfaces\MediaRepositoryInterface;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use App\Traits\HandlesMedia;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class MovieService
{
    use HandlesMedia;

    public function __construct(
        private readonly MovieRepositoryInterface $movieRepository,
        private readonly MediaRepositoryInterface $mediaRepository,
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
                $this->deleteMedia($movie->poster);

                $this->saveMediaFiles(
                    mediaFiles: $dto->getMoviePoster(),
                    model: $movie,
                    collectionName: 'poster',
                    storagePath: 'posters'
                );
            }

            if ($dto->getMovieFrames() !== null) {
                $this->deleteMedia($movie->frames);

                $this->saveMediaFiles(
                    mediaFiles: $dto->getMovieFrames(),
                    model: $movie,
                    collectionName: 'frames',
                    storagePath: 'frames'
                );
            }
        } catch (\Exception $e) {
            Log::error("Failed to save poster or frames: {$e->getMessage()} movie id: {$movie->id}");
        }
        return $movie;
    }

    /**
     * Create and Save Movie with Media Attachments
     *
     * @param CreateMovieDTO $dto
     * @return Movie
     */
    public function createAndSaveMovieWithMedia(CreateMovieDTO $dto): Movie
    {
        $movie = $this->movieRepository->createMovie(dto: $dto);

        try {
            $this->saveMediaFiles(
                mediaFiles: $dto->getMoviePoster(),
                model: $movie,
                collectionName: 'poster',
                storagePath: 'posters'
            );
            $this->saveMediaFiles(
                mediaFiles: $dto->getMovieFrames(),
                model: $movie,
                collectionName: 'frames',
                storagePath: 'frames'
            );
        } catch (\Throwable $e) {
            Log::error("Failed to save poster or frames: {$e->getMessage()} movie id: {$movie->id}");
        }

        return $movie;
    }

    /**
     * Delete a movie
     *
     * @param int $movieId
     * @return void
     */
    public function deleteMovie(int $movieId): void
    {
        $movie = $this->movieRepository->getMovieByIdOrFail(movieId: $movieId);

        try {
            $this->deleteMedia($movie->poster);
            $this->deleteMedia($movie->frames);
            if (!$movie->delete()) {
                Log::error("Failed to delete movie: Movie deletion failed. Movie ID: {$movie->id}");
            }
        } catch (\Exception $e) {
            Log::error("Failed to delete movie: {$e->getMessage()}. Movie ID: {$movie->id}");
        }
    }
}
