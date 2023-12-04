<?php

namespace App\Services;

use App\DTO\Theatres\CreateTheatreDTO;
use App\DTO\Theatres\DeleteTheatreDTO;
use App\DTO\Theatres\EditTheatreDTO;
use App\DTO\Theatres\SearchTheatreDTO;
use App\DTO\Theatres\UpdateTheatreDTO;
use App\Enums\RolesUsersEnum;
use App\Models\Cinema;
use App\Models\Media;
use App\Repositories\Interfaces\MediaRepositoryInterface;
use App\Repositories\Interfaces\TheatreRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TheatreService
{
    public function __construct(
        private readonly TheatreRepositoryInterface $theatreRepository,
        private readonly MediaRepositoryInterface   $mediaRepository,
    )
    {
    }

    /**
     * Getting all cinemas PaginateList
     *
     * @return LengthAwarePaginator
     */
    public function getPaginatedCinemasList(): LengthAwarePaginator
    {
        return $this->theatreRepository->getCinemasPaginateList();
    }

    /**
     * Returns a paginated list of cinemas with screens.
     *
     * @param SearchTheatreDTO $dto
     * @return LengthAwarePaginator
     */
    public function getTheatresWithHallsPaginated(SearchTheatreDTO $dto): LengthAwarePaginator
    {
        if (
            $dto->getProducer()->hasRole(RolesUsersEnum::SUPER_ADMIN->value)
//            || $dto->getProducer()->hasRole(RolesUsersEnum::MANAGER->value)
        ) {
            return $this->theatreRepository->getTheatresPaginateList(
                searchTerm: $dto->getSearchTerm(),
                relations: ['halls'],
            );
        }

        return $this->theatreRepository->getFilteredTheatresByProducer(
            authUser: $dto->getProducer(),
            searchTerm: $dto->getSearchTerm(),
            relations: ['halls'],
        );
    }

    /**
     *  Create and save a new theatre entity along with associated media (images).
     *  The user's role is considered to determine the appropriate actions.
     *
     * @param CreateTheatreDTO $dto
     * @return Cinema
     */
    public function createAndSaveTheatreWithMedia(CreateTheatreDTO $dto): Cinema
    {
        if ($dto->getUser()->hasRole(RolesUsersEnum::CINEMA_ADMIN->value)) {
            $theatre = $this->theatreRepository->createTheatreAndAttachUser(dto: $dto);
        } else {
            $theatre = $this->theatreRepository->createTheatre(dto: $dto);
        }

        try {
            $this->saveMedia(dto: $dto, theatre: $theatre);
        } catch (\Throwable $e) {
            Log::error("Failed to save images: {$e->getMessage()} theatre id: {$theatre->id}");
        }
        return $theatre;
    }

    /**
     *  Save media (images) associated with a theatre based on the provided DTO and theatre entity.
     *
     * @param UpdateTheatreDTO|CreateTheatreDTO $dto
     * @param Cinema $theatre
     * @return void
     */
    public function saveMedia(UpdateTheatreDTO|CreateTheatreDTO $dto, Cinema $theatre): void
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

    /**
     *  Retrieve theatre data for editing, including information about the theatre, its halls, media, and seat types.
     *
     * @param EditTheatreDTO $dto
     * @return array
     */
    public function getTheatreDataForEdit(EditTheatreDTO $dto): array
    {
        $theatre = $this->theatreRepository->getTheatreByIdOrFail(
            theatreId: $dto->getTheatreId(),
            relations: ['halls.seats', 'medias']
        );
        $seatsTypes = $theatre->seatTypes;
        $halls = $theatre->halls;
        $media = $theatre->medias;

        return compact('theatre', 'halls', 'media', 'seatsTypes');
    }

    /**
     *  Update theatre information based on the provided UpdateTheatreDTO.
     *  This method handles the deletion and addition of media (images) associated with the theatre.
     *
     * @param UpdateTheatreDTO $dto
     * @return Cinema
     * @throws \Exception
     */
    public function updateTheatre(UpdateTheatreDTO $dto): Cinema
    {
        $theatre = $this->theatreRepository->getTheatreByIdOrFail($dto->getTheatreId());

        try {
            $this->deleteMedia($theatre->medias);
            $this->theatreRepository->updateTheatreInfo(theatre: $theatre, dto: $dto);
            $this->saveMedia(dto: $dto, theatre: $theatre);
        } catch (\Throwable $e) {
            Log::error("Failed to save or delete images: {$e->getMessage()}, theatre id: {$theatre->id}");

            throw new \Exception('Failed to update theatre information. Please try again later.');
        }

        return $theatre;
    }

    /**
     * Deletes the media file(s) and associated Media object. Supports both a single Media object and a Media collection.
     *
     * @param Media|Collection|null $media
     * @return void
     */
    private function deleteMedia(Media|Collection|null $media): void
    {
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

    /**
     *  Deletes a theater along with its associated media files.
     *
     * @param int $theatreId
     * @return void
     * @throws \Exception
     */
    public function deleteTheatre(int $theatreId): void
    {
        $theatre = $this->theatreRepository->getTheatreByIdOrFail(theatreId: $theatreId, relations: ['halls.medias', 'medias']);

        try {
            foreach ($theatre->halls as $hall) {
                $this->deleteMedia($hall->medias);
            }
            $this->deleteMedia($theatre->medias);

            $theatre->delete();
        } catch (\Throwable $e) {
            Log::error("Failed to delete theatre: {$e->getMessage()}. Theatre ID: {$theatre->id}");

            throw new \Exception('Failed to delete theatre. Please try again later.');
        }
    }
}
