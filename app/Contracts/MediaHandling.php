<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Http\UploadedFile;

interface MediaHandling
{
    /**
     * @param string|null ...$collectionNames
     * @return void
     */
    public function deleteMedia(?string ...$collectionNames): void;

    /**
     * @param UploadedFile $file
     * @param string $collectionName
     * @return void
     */
    public function saveFile(UploadedFile $file, string $collectionName = 'default'): void;

    /**
     * @return MorphMany
     */
    public function medias(): MorphMany;
}
