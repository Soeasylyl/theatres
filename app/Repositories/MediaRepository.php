<?php

namespace App\Repositories;

use App\Models\Cinema;
use App\Models\Media;
use App\Models\Movie;
use App\Repositories\Interfaces\MediaRepositoryInterface;

class MediaRepository implements MediaRepositoryInterface
{
    /**
     * Creates a new media file for a theater or movie model and associates it with the specified collection.
     *
     * @param Movie|Cinema $model
     * @param string $path
     * @param string $collection
     * @return Movie|Cinema
     */
    public function createMediaWithCollection(Movie|Cinema $model, string $path, string $collection): Movie|Cinema
    {
        $media = new Media([
            'path' => 'storage/' . $path,
            'collection' => $collection,
        ]);

        $model->medias()->save($media);

        return $model;
    }
}
