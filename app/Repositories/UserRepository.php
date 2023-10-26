<?php

namespace App\Repositories;


use App\DTO\Users\CreateDTO;
use App\Enums\RolesUsersEnum;
use app\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;


class UserRepository implements UserRepositoryInterface
{
    /**
     * Obtaining information about all users except authorized and super administrator
     *
     * @return LengthAwarePaginator
     */
    public function getAllUsers(): LengthAwarePaginator
    {
        return User::query()
            ->whereDoesntHave('roles', function (Builder $query) {
                $query->where('name', RolesUsersEnum::SUPER_ADMIN);
            })
            ->whereNot('id', \Auth::user()->id)->paginate(10);
    }

    /**
     * Receiving all users from one cinema, except the authorized one
     *
     * @param $cinemaId
     * @param User $authUser
     * @return LengthAwarePaginator
     */
    public function getUsersByCinema($cinemaId, User $authUser): LengthAwarePaginator
    {
        return User::query()
            ->whereHas('cinemas', function ($query) use ($cinemaId) {
                $query->where('cinema_id', $cinemaId);
            })
            ->where('id', '!=', $authUser->id)
            ->paginate(10);
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
     * @param $requestDTO
     * @param User $user
     * @return bool
     */
    public function updateInfoByUser($requestDTO, User $user): bool
    {
        return $user->update([
            'name' => $requestDTO->getName(),
            'email' => $requestDTO->getEmail(),
            'phone' => $requestDTO->getPhone(),
        ]);
    }

    /**
     * Changing the user password
     *
     * @param $requestDTO
     * @param User $user
     * @return bool
     */
    public function updatePasswordByUser($requestDTO, User $user): bool
    {
        return $user->update([
            'password' => $requestDTO->getPassword()
        ]);
    }

    /**
     * Adding the selected role to a user
     *
     * @param User $user
     * @param RolesUsersEnum $role
     * @return User
     */
    public function addRoleByUser(User $user, RolesUsersEnum $role): User
    {
        return $user->assignRole($role->value);
    }

    /**
     * Removing all user roles
     *
     * @param User $user
     * @return User
     */
    public function deleteAllRoles(User $user): User
    {
        return $user->syncRoles([]);
    }

    /**
     * @param CreateDTO $requestDTO
     * @return mixed
     */
    public function createUser(CreateDTO $requestDTO): mixed
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
