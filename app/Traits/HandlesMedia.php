<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use App\Models\Media;
use Illuminate\Http\UploadedFile;

trait HandlesMedia
{

    /**
     *  Listen for the 'deleting' event and automatically
     *  trigger the deleteMedia method when deleting the model.
     *
     * @return void
     */
    public static function bootHandlesMedia(): void
    {
        static::deleting(function ($model) {
            if (in_array(SoftDeletes::class, class_uses_recursive($model))) {
                if (!$model->isForceDeleting()) {
                    return;
                }
            }

            $model->deleteMedia();
        });
    }

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
        $this->medias()
             ->when(!empty($collectionNames), function (Builder $query) use ($collectionNames) {
                  return $query->whereIn('collection', $collectionNames);
             })
             ->chunk(10, function (Collection $medias) {
                  $medias->each(fn (Media $media) =>
                      $media->delete());
             });
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
