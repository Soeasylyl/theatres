<?php

namespace App\Repositories\Interfaces;

use App\Models\Movie;

interface MediaRepositoryInterface
{
    /**
     * Create a new media record with the specified path and collection for the given movie.
     *
     * @param Movie $movie The movie to associate the media with.
     * @param string $path The path to the media file.
     * @param string|null $collection The name of the media collection.
     * @return Movie The updated movie model.
     */
    public function createMediaWithCollection(Movie $movie, string $path, ?string $collection = 'default'): Movie;
}
