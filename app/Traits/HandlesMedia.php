<?php

namespace App\Traits;

use App\Repositories\Interfaces\MediaRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
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
     * @param string $collectionName
     * @param string $storagePath
     * @return void
     */
    protected function saveMediaFiles(UploadedFile|array $mediaFiles, string $collectionName, string $storagePath): void
    {
        \Log::info('saveMediaFiles called');
        // Ensure that $mediaFiles is always treated as an array, even if it's a single file.
        $mediaFiles = is_array($mediaFiles) ? $mediaFiles : [$mediaFiles];

        if ($mediaFiles) {
            foreach ($mediaFiles as $file) {
                $filePath = $file->store($storagePath, 'public');

                $this->medias()->create([
                    'path' => 'storage/' . $filePath,
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
    protected function deleteMedia(Media|Collection|null $media): void
    {
        \Log::info('deleteMedia called');
        if ($media instanceof Media) {
            $path = str_replace('storage/', '', $media->path);
            Storage::disk('public')->delete($path);

            $media->delete();
        } elseif ($media instanceof Collection) {
            foreach ($media as $singleMedia) {
                $this->deleteMedia($singleMedia);
            }
        }
    }

    abstract public function medias();
}
