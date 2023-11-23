<?php

namespace App\Repositories;

use App\Models\Media;
use App\Models\Movie;
use App\Repositories\Interfaces\MediaRepositoryInterface;

class MediaRepository implements MediaRepositoryInterface
{
    /**
     * Create a new media record with the specified path and collection for the given movie.
     *
     * @param Movie $movie The movie to associate the media with.
     * @param string $path The path to the media file.
     * @param string $collection The name of the media collection.
     * @return Movie The updated movie model.
     */
    public function createMediaWithCollection(Movie $movie, string $path, string $collection): Movie
    {
        $media = new Media([
            'path' => 'storage/' . $path,
            'collection' => $collection,
        ]);

        $movie->medias()->save($media);

        return $movie;
    }
}
