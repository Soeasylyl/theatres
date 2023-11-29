<?php

namespace App\Services;

use App\DTO\Theatres\CreateTheatreDTO;
use App\Models\Cinema;
use App\Repositories\Interfaces\MediaRepositoryInterface;
use App\Repositories\Interfaces\TheatreRepositoryInterface;
use Illuminate\Support\Facades\Log;

class TheatreService
{
    public function __construct(
        private readonly TheatreRepositoryInterface $theatreRepository,
        private readonly MediaRepositoryInterface   $mediaRepository,
    )
    {
    }

    public function createAndSaveTheatreWithMedia(CreateTheatreDTO $dto): Cinema
    {
        $theatre = $this->theatreRepository->createTheatre(dto: $dto);

        try {
            $this->saveMedia(dto: $dto, theatre: $theatre);
        } catch (\Throwable $e) {
            Log::error("Failed to save images: {$e->getMessage()} theatre id: {$theatre->id}");
        }
        return $theatre;
    }

    public function saveMedia(CreateTheatreDTO $dto, Cinema $theatre): void
    {
        if ($dto->getTheatreImages()) {
            foreach ($dto->getTheatreImages() as $image) {
                $imagePath = $image->store('theatres', 'public');

                $this->mediaRepository->createMediaWithCollection(
                    model: $theatre,
                    path: $imagePath,
                    collection: 'image',
                );
            }
        }
    }
}
