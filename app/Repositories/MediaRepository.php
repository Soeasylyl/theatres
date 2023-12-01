<?php

namespace App\Repositories;

use App\Models\Movie;
use App\Repositories\Interfaces\MediaRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class MediaRepository implements MediaRepositoryInterface
{
    /**
     * Create a new media record with the specified path and collection for the given model.
     *
     * @param Model $model
     * @param string $path The path to the media file.
     * @param string|null $collection The name of the media collection.
     * @return Movie The updated movie model.
     */
    public function createMediaWithCollection(Model $model, string $path, ?string $collection = 'default'): Model
    {
        $model->medias()->create([
            'path' => 'storage/' . $path,
            'collection' => $collection,
        ]);

        return $model;
    }
}
