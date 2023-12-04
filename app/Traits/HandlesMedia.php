<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use App\Models\Media;
use Illuminate\Http\UploadedFile;

trait HandlesMedia
{
    /**
     * Save media files for a model in a specified collection and storage path.
     *
     * @param UploadedFile|array $mediaFiles
     * @param string|null $collectionName
     * @param string $storagePath
     * @return void
     */
    public function saveMediaFiles(UploadedFile|array $mediaFiles, string $storagePath, ?string $collectionName = 'default'): void
    {
        // Ensure that $mediaFiles is always treated as an array, even if it's a single file.
        $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

        if (!empty($mediaFiles)) {
            foreach ($mediaFiles as $file) {
                $filePath = $file->store($storagePath, 'public');

                $this->medias()->create([
                    'path' => 'medias/' . $filePath,
                    'collection' => $collectionName,
                ]);
            }
        }
    }

    /**
     * Delete media files associated with a model or a collection of media records.
     *
     * @param Collection|Media|null $media
     * @return void
     */
    public function deleteMedia(Media|Collection|null $media): void
    {
        if ($media instanceof Media) {
            $path = str_replace('medias/', '', $media->path);
            Storage::disk('public')->delete($path);

            $media->delete();
        } elseif ($media instanceof Collection) {
            foreach ($media as $singleMedia) {
                $this->deleteMedia($singleMedia);
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
