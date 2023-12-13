<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use App\Models\Media;
use Illuminate\Http\UploadedFile;

trait HandlesMedia
{
    /**
     * Save a single file to the specified media collection for the model.
     *
     * @param UploadedFile $file
     * @param string $collectionName
     * @return void
     */
    public function saveFile(UploadedFile $file, string $collectionName = 'default'): void
    {
        $filePath = $file->store($collectionName, 'public');

        $this->medias()->create([
            'path' => $filePath,
            'collection' => $collectionName,
        ]);
    }

    /**
     * Save multiple files to the specified media collection for the model.
     *
     * @param array $mediaFiles
     * @param string|null $collectionName
     * @return void
     */
    public function saveMultipleFiles(array $mediaFiles, ?string $collectionName): void
    {
        foreach ($mediaFiles as $file) {
            if ($file instanceof UploadedFile) {
                $this->saveFile(file: $file, collectionName: $collectionName);
            }
        }
    }

    /**
     * Delete media files associated with a model or a collection of media records.
     *
     * @param string|null ...$collectionNames
     * @return void
     */
    public function deleteMedia(?string ...$collectionNames): void
    {
        if (empty($collectionNames)) {
            $this->chunk(10, function (Collection $query) {
                $query->each(function (Media $q) {
                    $q->delete();
                });
            });
        } else {
            foreach ($collectionNames as $collectionName) {
                $this->medias()
                    ->where('collection', $collectionName)
                    ->chunk(10, function (Collection $query) {
                        $query->each(function (Media $q) {
                            $q->delete();
                        });
                    });
            }
        }
    }

    /**
     * @return MorphMany
     */
    public function medias(): MorphMany
    {
        return $this->morphMany(
            related: Media::class,
            name: 'model',
        );
    }
}
