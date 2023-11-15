<?php

namespace App\Repositories;

use App\DTO\Users\CreateUserDTO;
use App\DTO\Users\UpdateUserInfoDTO;
use App\DTO\Users\UpdateUserPasswordDTO;
use App\Enums\RolesUsersEnum;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


class UserRepository implements UserRepositoryInterface
{
    /**
     * Obtaining information about all users except authorized and super administrator
     *
     * @param int $authUserId
     * @param string|null $searchTerm
     * @param array|null $relations
     * @return LengthAwarePaginator
     */
    public function getUsersWithoutAdminRolePaginatedList(int $authUserId, ?string $searchTerm, ?array $relations = []): LengthAwarePaginator
    {
        return User::with($relations)
            ->whereDoesntHave('roles', function (Builder $query) {
                $query->where('name', RolesUsersEnum::SUPER_ADMIN->value);
            })
            ->whereNot('id', $authUserId)
            ->when($searchTerm, function (Builder $query) use ($searchTerm) {
                $query->where('name', 'ilike', "%$searchTerm%");
            })
            ->paginate(config('app.pagination_limit'));
    }

    /**
     * Receiving all users from one cinema, except the authorized one
     *
     * @param Collection $cinemaIds
     * @param int $authUserId
     * @param string|null $searchTerm
     * @return LengthAwarePaginator
     */
    public function getUsersByCinemaPaginatedList(Collection $cinemaIds, int $authUserId, ?string $searchTerm): LengthAwarePaginator
    {
        return User::query()
            ->where('id', '!=', $authUserId)
            ->when($cinemaIds->isNotEmpty(), function (Builder $query) use ($cinemaIds) {
                $query->whereHas('cinemas', function (Builder $query) use ($cinemaIds) {
                    $query->whereIn('cinema_id', $cinemaIds->toArray());
                });
            })
            ->when($searchTerm, function (Builder $query) use ($searchTerm) {
                $query->where('name', 'ilike', "%$searchTerm%");
            })
            ->paginate(config('app.pagination_limit'));
    }

    /**
     * Searching for a user by ID
     *
     * @param int $userId
     * @param array|null $relations
     * @return User
     */
    public function getUserByIdOrFail(int $userId, ?array $relations = []): User
    {
        return User::with($relations)->findOrFail($userId);
    }

    /**
     * Changing user information
     *
     * @param UpdateUserInfoDTO $requestDTO
     * @param User $user
     * @return User
     */
    public function updateInfoByUser(UpdateUserInfoDTO $requestDTO, User $user): User
    {
        $user->update([
            'name' => $requestDTO->getName(),
            'email' => $requestDTO->getEmail(),
            'phone' => $requestDTO->getPhone(),
        ]);

        return $user;
    }

    /**
     * Changing the user password
     *
     * @param UpdateUserPasswordDTO $requestDTO
     * @param User $user
     * @return User
     */
    public function updatePasswordByUser(UpdateUserPasswordDTO $requestDTO, User $user): User
    {
        $user->update([
            'password' => $requestDTO->getPassword()
        ]);

        return $user;
    }

    /**
     * Create a new user based on the provided CreateUserDTO.
     *
     * @param CreateUserDTO $requestDTO
     * @return User
     */
    public function createUser(CreateUserDTO $requestDTO): User
    {
        return User::create([
            'name' => $requestDTO->getName(),
            'email' => $requestDTO->getEmail(),
            'phone' => $requestDTO->getPhone(),
            'password' => $requestDTO->getPassword(),
        ]);
    }

    /**
     * Attach a user to a cinema.
     *
     * @param User $user
     * @param int $cinemaId
     * @return void
     */
    public function attachUserToCinema(User $user, int $cinemaId): void
    {
        $user->cinemas()->attach($cinemaId);
    }

    /**
     * Blocks the user for a certain amount of time.
     *
     * @param User $user
     * @param Carbon $date
     * @return User
     */
    public function blockUser(User $user, Carbon $date): User
    {
        $user->update([
            'blocked_until' => $date
        ]);

        return $user;
    }
}
