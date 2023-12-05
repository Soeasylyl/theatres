<?php

namespace App\Repositories\Interfaces;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Model;

interface MediaRepositoryInterface
{
    /**
     * Create a new media record with the specified path and collection for the given movie.
     *
     * @param Model $model
     * @param string $path The path to the media file.
     * @param string|null $collection The name of the media collection.
     * @return Movie The updated movie model.
     */
    public function createMediaWithCollection(Model $model, string $path, ?string $collection = 'default'): Model;
}
