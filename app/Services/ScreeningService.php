<?php

namespace App\Services;

use App\DTO\SeatTypes\CreateSeatTypeDTO;
use App\DTO\SeatTypes\DeleteSeatTypeDTO;
use App\DTO\SeatTypes\UpdateSeatTypeDTO;
use App\DTO\Screening\SearchScreeningDTO;
use App\Enums\RolesUsersEnum;
use App\Models\SeatType;
use App\Repositories\Interfaces\SeatTypeRepositoryInterface;
use App\Repositories\ScreeningRepository;
use App\Repositories\TheatreRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class ScreeningService
{
    public function __construct(
        private readonly ScreeningRepository $sessionRepository,
        private readonly TheatreRepository   $theatreRepository,
    )
    {
    }

    public function getScreeningsBasedOnRolePaginated(SearchScreeningDTO $dto): array
    {
        if ($dto->getProducer()->hasAnyRole(RolesUsersEnum::SUPER_ADMIN->value, RolesUsersEnum::MODERATOR->value)) {
            $screenings = $this->sessionRepository->getSessionsPaginateList(
                theatreId: $dto->getTheatreId(),
                date: $dto->getDate()
            );
            $theatres = $this->theatreRepository->getTheatresPaginateList(relations: ['halls']);

            return [
                'screenings' => $screenings,
                'theatres' => $theatres,
            ];
        }
        $screenings = $this->sessionRepository->getFilteredSessionsByProducer(
            producer: $dto->getProducer(),
            theatreId: $dto->getTheatreId(),
            date: $dto->getDate()
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
}
