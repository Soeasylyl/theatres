<?php

namespace App\Services;

use App\DTO\Theatres\CreateTheatreDTO;
use App\DTO\Theatres\DeleteTheatreDTO;
use App\DTO\Theatres\EditTheatreDTO;
use App\DTO\Theatres\SearchTheatreDTO;
use App\DTO\Theatres\UpdateTheatreDTO;
use App\Enums\RolesUsersEnum;
use App\Models\Theatre;
use App\Repositories\Interfaces\TheatreRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TheatreService
{
    public function __construct(
        private readonly TheatreRepositoryInterface $theatreRepository,
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
        if ($dto->getProducer()->hasAnyRole(RolesUsersEnum::SUPER_ADMIN->value, RolesUsersEnum::MODERATOR->value)) {
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
     * @return Theatre
     * @throws \Throwable
     */
    public function createAndSaveTheatreWithMedia(CreateTheatreDTO $dto): Theatre
    {
        $theatre = $this->theatreRepository->createTheatre(dto: $dto);
        if ($dto->getUser()->hasRole(RolesUsersEnum::CINEMA_ADMIN->value)) {
            $theatre->users()->attach($dto->getUser()->id);
        }

        try {
        if ($dto->getTheatreImages() !== null) {
            $theatre->saveMultipleFiles(
                mediaFiles: $dto->getTheatreImages(),
                collectionName: 'theatres'
            );
        }
        } catch (\Throwable $e) {
            Log::error("Failed to save images: {$e->getMessage()} theatre id: {$theatre->id}");

            throw $e;
        }

        return $theatre;
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
     * @return Theatre
     * @throws \Exception
     * @throws \Throwable
     */
    public function updateTheatre(UpdateTheatreDTO $dto): Theatre
    {
        $theatre = $this->theatreRepository->getTheatreByIdOrFail($dto->getTheatreId());

        try {
            $this->theatreRepository->updateTheatreInfo(theatre: $theatre, dto: $dto);
            if ($dto->getTheatreImages() !== null) {
                $theatre->deleteMedia('theatres');
                $theatre->saveMultipleFiles(
                    mediaFiles: $dto->getTheatreImages(),
                    collectionName: 'theatres'
                );
            }

        } catch (\Throwable $e) {
            Log::error("Failed to save or delete images: {$e->getMessage()}, theatre id: {$theatre->id}");

            throw $e;
        }

        return $theatre;
    }

    /**
     *  Deletes a theater along with its associated media files.
     *
     * @param int $theatreId
     * @return void
     * @throws \Exception
     * @throws \Throwable
     */
    public function deleteTheatre(int $theatreId): void
    {
        $theatre = $this->theatreRepository->getTheatreByIdOrFail(theatreId: $theatreId, relations: ['halls.medias', 'medias']);

        try {
            DB::transaction(function () use ($theatre) {
                foreach ($theatre->halls as $hall) {
                    $hall->deleteMedia('halls');
                    $hall->delete();
                }

                $theatre->deleteMedia('theatres');
                $theatre->delete();
            });
        } catch (\Throwable $e) {
            Log::error("Failed to delete theatre: {$e->getMessage()}. Theatre ID: {$theatre->id}");

            throw $e;
        }
    }
}
