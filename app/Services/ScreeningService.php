<?php

namespace App\Services;

use App\DTO\Halls\GetHallsDTO;
use App\DTO\SeatTypes\CreateSeatTypeDTO;
use App\DTO\SeatTypes\DeleteSeatTypeDTO;
use App\DTO\SeatTypes\UpdateSeatTypeDTO;
use App\DTO\Screening\SearchScreeningDTO;
use App\Enums\RolesUsersEnum;
use App\Models\SeatType;
use App\Models\User;
use App\Repositories\HallRepository;
use App\Repositories\Interfaces\SeatTypeRepositoryInterface;
use App\Repositories\ScreeningRepository;
use App\Repositories\TheatreRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ScreeningService
{
    public function __construct(
        private readonly ScreeningRepository $screeningRepository,
        private readonly TheatreRepository   $theatreRepository,
        private readonly HallRepository      $hallRepository,
    )
    {
    }

    /**
     *  Retrieves a filtered list of shows and cinemas with pagination depending on the user's role.
     *
     * @param SearchScreeningDTO $dto
     * @return array
     */
    public function getScreeningsBasedOnRolePaginated(SearchScreeningDTO $dto): array
    {
        if ($dto->getProducer()->hasAnyRole(RolesUsersEnum::SUPER_ADMIN->value, RolesUsersEnum::MODERATOR->value)) {
            $screenings = $this->screeningRepository->getScreeningsPaginateList(
                fScreening: $dto->getFScreenings(),
                searchTerm: $dto->getSearchTerm(),
                theatreId: $dto->getTheatreId(),
                date: $dto->getDate(),
            );
            $theatres = $this->theatreRepository->getTheatresPaginateList(relations: ['halls']);

            return [
                'screenings' => $screenings,
                'theatres' => $theatres,
            ];
        }

        $screenings = $this->screeningRepository->getFilteredScreeningsByProducer(
            producer: $dto->getProducer(),
            fScreening: $dto->getFScreenings(),
            searchTerm: $dto->getSearchTerm(),
            theatreId: $dto->getTheatreId(),
            date: $dto->getDate(),
        );
        $theatres = $this->theatreRepository->getFilteredTheatresByProducer(
            authUser: $dto->getProducer(),
            relations: ['halls']
        );

        return [
            'screenings' => $screenings,
            'theatres' => $theatres,
        ];
    }

    /**
     * Retrieves a list of cinemas for the user based on his role.
     *
     * @param User $producer
     * @return LengthAwarePaginator
     */
    public function getTheatres(User $producer): LengthAwarePaginator
    {
        if ($producer->hasAnyRole(RolesUsersEnum::SUPER_ADMIN->value, RolesUsersEnum::MODERATOR->value)) {
            return $this->theatreRepository->getTheatresPaginateList(relations: ['halls']);
        }

        return $this->theatreRepository->getFilteredTheatresByProducer(
            authUser: $producer,
        );
    }

    /**
     * Retrieves a list of screens for the specified theatre.
     *
     * @param GetHallsDTO $dto
     * @return Collection
     */
    public function getHalls(GetHallsDTO $dto): Collection
    {
        return $this->hallRepository->getHallsByTheatreId(
            theatreId: $dto->getTheatreId(),
            columns: ['id', 'name'],
        );
    }
}
