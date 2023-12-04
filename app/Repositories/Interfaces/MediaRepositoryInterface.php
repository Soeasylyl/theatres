<?php

namespace App\Repositories\Interfaces;

use App\Models\Cinema;
use App\Models\Media;
use App\Models\Movie;

interface MediaRepositoryInterface
{
    /**
     * Creates a new media file for a theater or movie model and associates it with the specified collection.
     *
     * @param Movie|Cinema $model
     * @param string $path
     * @param string|null $collection
     * @return Media
     */
    public function createMediaWithCollection(Movie|Cinema $model, string $path, ?string $collection = 'default'): Media;
}
