<?php

namespace App\Services;

use App\DTO\Movies\CreateMovieDTO;
use App\DTO\Movies\UpdateMovieDTO;
use App\DTO\Movies\SearchMovieDTO;
use App\Models\Media;
use App\Models\Movie;
use App\Repositories\Interfaces\MediaRepositoryInterface;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MovieService
{
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
        $slug = $this->generateUniqueSlug($dto->getName(), $dto->getMovieId());
        $movie = $this->movieRepository->getMovieByIdOrFail(
            movieId: $dto->getMovieId(),
            relations: ['medias'],
        );

        try {
            if ($dto->getMoviePoster() !== null) {
                $this->deleteMediaByCollection(movie: $movie, collection: 'poster');
                $movie = $this->savePosterMedia(dto: $dto, movie: $movie);
            }

            if ($dto->getMovieFrames() !== null) {
                $this->deleteMediaByCollection(movie: $movie, collection: 'frames');
                $movie = $this->saveFramesMedia(dto: $dto, movie: $movie);
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
        $slug = $this->generateUniqueSlug($dto->getName());
        $movie = $this->movieRepository->createMovie(dto: $dto, slug: $slug);

        try {
            $this->savePosterMedia(dto: $dto, movie: $movie);
            $this->saveFramesMedia(dto: $dto, movie: $movie);
        } catch (\Throwable $e) {
            Log::error("Failed to save poster or frames: {$e->getMessage()} movie id: {$movie->id}");
        }

        return $movie;
    }

    /**
     *  Deletes all media files of a specific collection for a given movie.
     *
     * @param Movie $movie
     * @param string $collection
     * @return void
     */
    private function deleteMediaByCollection(Movie $movie, string $collection): void
    {
        $movie->medias()
            ->where('collection', $collection)
            ->delete();
    }

    /**
     * Save the poster media for the movie if provided in the DTO.
     *
     * @param UpdateMovieDTO|CreateMovieDTO $dto
     * @param Movie $movie
     * @return void
     */
    private function savePosterMedia(UpdateMovieDTO|CreateMovieDTO $dto, Movie $movie): void
    {
        if ($dto->getMoviePoster()) {
            $posterPath = $dto->getMoviePoster()->store('posters', 'public');

             $this->mediaRepository->createMediaWithCollection(
                movie: $movie,
                path: $posterPath,
                collection: 'poster',
            );
        }
    }

    /**
     * Save the frame media for the movie if provided in the DTO.
     *
     * @param UpdateMovieDTO|CreateMovieDTO $dto
     * @param Movie $movie
     * @return void
     */
    private function saveFramesMedia(UpdateMovieDTO|CreateMovieDTO $dto, Movie $movie): void
    {
        if ($dto->getMovieFrames()) {
            foreach ($dto->getMovieFrames() as $frame) {
                $framePath = $frame->store('frames', 'public');

                 $this->mediaRepository->createMediaWithCollection(
                    movie: $movie,
                    path: $framePath,
                    collection: 'frames',
                );
            }
        }
    }

    /**
     * Generates a unique "slug" (URL-friendly string) for a movie based on its title.
     *
     * @param string $name
     * @param int $id
     * @param int $attempt
     *
     * @return string
     */
    private function generateUniqueSlug(string $name, int $id = 0, int $attempt = 1): string
    {
        $transliteratedTitle = Str::slug($name);
        $slug = strtolower(str_replace(' ', '-', $transliteratedTitle));

        $count = $this->movieRepository->countMoviesWithSlugExcludingId(slug: $slug, id: $id);

        if ($count > 0) {
            $slug = $slug . '-' . $attempt;
            // Recursive call to the function with a new attempt identifier
            return $this->generateUniqueSlug(
                name: $name,
                id: $id,
                attempt: $attempt + 1,
            );
        }

        return $slug;
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

    /**
     * Deletes the media file(s) and associated Media object. Supports both a single Media object and a Media collection.
     *
     * @param Media|Collection|null $media
     * @return void
     */
    private function deleteMedia(Media|Collection|null $media): void
    {
        if ($media instanceof Media) {
            $path = str_replace('storage/', '',$media->path);
            Storage::disk('public')->delete($path);

            $media->delete();
        } elseif ($media instanceof Collection) {

            foreach ($media as $singleMedia) {
                $this->deleteMedia($singleMedia);
            }
        }
    }
}
