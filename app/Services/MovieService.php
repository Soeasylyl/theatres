<?php

namespace App\Services;

use App\DTO\Movies\MovieDTO;
use App\DTO\Movies\SearchMovieDTO;
use App\Models\Movie;
use App\Repositories\Interfaces\MediaRepositoryInterface;
use App\Repositories\Interfaces\MovieRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
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
     * @param MovieDTO $dto The DTO containing updated movie information.
     * @return Movie The updated movie model.
     */
    public function updateMovie(MovieDTO $dto): Movie
    {
        $slug = $this->generateUniqueSlug($dto->getName(), $dto->getMovieId());
        $movie = $this->movieRepository->getMovieWithRelationsOrFail(
            movieId: $dto->getMovieId(),
            relations: ['medias'],
        );

        try {
            $movie->medias()->delete();

            $movie = $this->savePosterMedia(dto: $dto, movie: $movie);
            $movie = $this->saveFramesMedia(dto: $dto, movie: $movie);
        } catch (\Exception $e) {
            Log::error("Failed to save poster or frames: {$e->getMessage()} movie id: {$movie->id}");
        }
        return $this->movieRepository->updateMovieInfo(
            movie: $movie,
            dto: $dto,
            slug: $slug
        );
    }

    /**
     * Save the poster media for the movie if provided in the DTO.
     *
     * @param MovieDTO $dto The DTO containing movie information.
     * @param Movie $movie The movie model to which the poster media will be associated.
     * @return Movie The movie model with updated poster media.
     */
    private function savePosterMedia(MovieDTO $dto, Movie $movie): Movie
    {
        if ($dto->getMoviePoster()) {
            $posterPath = $dto->getMoviePoster()->store('posters', 'public');

            $movie = $this->mediaRepository->createMediaWithCollection(
                movie: $movie,
                path: $posterPath,
                collection: 'poster',
            );
        }

        return $movie;
    }

    /**
     * Save the frame media for the movie if provided in the DTO.
     *
     * @param MovieDTO $dto The DTO containing movie information.
     * @param Movie $movie The movie model to which the frame media will be associated.
     * @return Movie The movie model with updated frame media.
     */
    private function saveFramesMedia(MovieDTO $dto, Movie $movie): Movie
    {
        if ($dto->getMovieFrames()) {
            foreach ($dto->getMovieFrames() as $frame) {
                $framePath = $frame->store('frames', 'public');

                $movie = $this->mediaRepository->createMediaWithCollection(
                    movie: $movie,
                    path: $framePath,
                    collection: 'frames',
                );
            }
        }

        return $movie;
    }

    /**
     * Generates a unique "slug" (URL-friendly string) for a movie based on its title.
     *
     * @param string $title The title of the movie.
     * @param int $id The ID of the movie.
     * @param int $attempt The number of attempts to generate a unique slug (default is 1).
     *
     * @return string A unique slug for the movie.
     */
    private function generateUniqueSlug(string $title, int $id, int $attempt = 1): string
    {
        $transliteratedTitle = Str::slug($title);
        $slug = strtolower(str_replace(' ', '-', $transliteratedTitle));

        $count = $this->movieRepository->countMoviesWithSlugExcludingId(slug: $slug, id: $id);

        if ($count > 0) {
            $slug = $slug . '-' . $attempt;
            // Recursive call to the function with a new attempt identifier
            return $this->generateUniqueSlug($title, $id, $attempt + 1);
        }

        return $slug;
    }
}
