<?php

namespace App\Services;

use App\Enums\RolesUsersEnum;
use App\Models\Cinema;
use App\Models\User;
use App\Repositories\Interfaces\CinemaRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;


class CinemaService
{
    public function __construct(
        private readonly UserRepositoryInterface   $userRepository,
        private readonly CinemaRepositoryInterface $cinemaRepository,)
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
     * Loads data for the admin dashboard.
     *
     * Retrieves the count of users excluding those with the role of super admin,
     * fetches cinema information along with the number of seats in each hall.
     *
     * @return array
     */
    public function loadAdminDashboardData(): array
    {
        $countUsers = $this->userRepository->getCountUsersWithoutRole(RolesUsersEnum::SUPER_ADMIN->value);

        $cinemas = $this->cinemaRepository->getCinemasWithHallsAndSeats();
        $countCinemas = $cinemas->count();
        $totalCountSeats = 0;

        foreach ($cinemas as $cinema) {
            $totalCountSeats += $cinema->halls->sum(function ($hall) {
                return $hall->seats->count();
            });
        }

        return compact('countUsers', 'countCinemas', 'cinemas', 'totalCountSeats');
    }

    /**
     * Returns a paginated list of cinemas with screens.
     *
     * @return LengthAwarePaginator
     */
    public function getCinemasWithHallsPaginated(): LengthAwarePaginator
    {
        return $this->cinemaRepository->getCinemasPaginateList();
    }
}
