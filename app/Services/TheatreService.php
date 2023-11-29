<?php

namespace App\Services;

use App\DTO\Theatres\CreateTheatreDTO;
use App\DTO\Theatres\SearchTheatreDTO;
use App\Enums\RolesUsersEnum;
use App\Models\Cinema;
use App\Repositories\Interfaces\MediaRepositoryInterface;
use App\Repositories\Interfaces\TheatreRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

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
