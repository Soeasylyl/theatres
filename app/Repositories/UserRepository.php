<?php

namespace App\Repositories;


use App\DTO\Users\CreateUserDTO;
use App\DTO\Users\UpdateUserInfoDTO;
use App\DTO\Users\UpdateUserPasswordDTO;
use App\Enums\RolesUsersEnum;
use app\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;


class UserRepository implements UserRepositoryInterface
{
    /**
     * Obtaining information about all users except authorized and super administrator
     *
     * @param int $authUserId
     * @return LengthAwarePaginator
     */
    public function getUsersWithoutAdminRolePaginatedList(int $authUserId): LengthAwarePaginator
    {
        return User::query()
            ->whereDoesntHave('roles', function (Builder $query) {
                $query->where('name', RolesUsersEnum::SUPER_ADMIN);
            })
            ->whereNot('id', $authUserId)
            ->paginate(config('app.pagination_limit'));
    }

    /**
     * Receiving all users from one cinema, except the authorized one
     *
     * @param Collection $cinemaId
     * @param int $authUserId
     * @return LengthAwarePaginator
     */
    public function getUsersByCinemaPaginatedList(Collection $cinemaId, int $authUserId): LengthAwarePaginator
    {
        return User::query()
            ->whereHas('cinemas', function ($query) use ($cinemaId) {
                $query->where('cinema_id', $cinemaId);
            })
            ->where('id', '!=', $authUserId)
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
     * Searching for a user by ID with roles
     *
     * @param int $userId
     * @return mixed
     */
    public function getUserByIdWithRolesOrFail(int $userId): mixed
    {
        return User::with('roles')->findOrFail($userId);
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
        return $user->refresh();
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

        return $user->refresh();
    }

    /**
     * @param CreateUserDTO $requestDTO
     * @return mixed
     */
    public function createUser(CreateUserDTO $requestDTO): mixed
    {
        return User::create([
            'name' => $requestDTO->getName(),
            'email' => $requestDTO->getEmail(),
            'phone' => $requestDTO->getPhone(),
            'password' => $requestDTO->getPassword(),
        ]);
    }

    /**
     * @param User $user
     * @param int $cinemaId
     * @return void
     */
    public function attachUserToCinema(User $user, int $cinemaId): void
    {
        $user->cinemas()->attach($cinemaId);
    }
}
