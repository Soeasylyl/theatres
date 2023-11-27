<?php

namespace App\Services;

use App\DTO\Theatres\SearchTheatreDTO;
use App\Enums\RolesUsersEnum;
use App\Repositories\Interfaces\CinemaRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class CinemaService
{
    public function __construct(
        private readonly CinemaRepositoryInterface $cinemaRepository)
    {
    }

    /**
     * Getting all cinemas PaginateList
     *
     * @return LengthAwarePaginator
     */
    public function getPaginatedCinemasList(): LengthAwarePaginator
    {
        return $this->cinemaRepository->getCinemasPaginateList();
    }

    /**
     * Returns a paginated list of cinemas with screens.
     *
     * @param SearchTheatreDTO $dto
     * @return LengthAwarePaginator
     */
    public function getCinemasWithHallsPaginated(SearchTheatreDTO $dto): LengthAwarePaginator
    {
        if (
            $dto->getProducer()->hasRole(RolesUsersEnum::SUPER_ADMIN->value)
//            || $dto->getProducer()->hasRole(RolesUsersEnum::MANAGER->value)
        ) {
            return $this->cinemaRepository->getTheatresPaginateList(
                searchTerm: $dto->getSearchTerm(),
                relations: ['halls'],
            );
        }

        return $this->cinemaRepository->getFilteredTheatresByProducer(
            authUser: $dto->getProducer(),
            relations: ['halls'],
        );
    }
}
