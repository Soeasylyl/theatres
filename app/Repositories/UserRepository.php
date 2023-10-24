<?php

namespace App\Repositories;


use App\DTO\Users\CreateUserDTO;
use App\Enums\RolesUsersEnum;
use app\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;


class UserRepository implements UserRepositoryInterface
{
    /*
     * Obtaining information about all users except authorized and super administrator
     */
    public function getAllUsers(): array|\Illuminate\Pagination\LengthAwarePaginator|\LaravelIdea\Helper\App\Models\_IH_User_C|\Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        return User::whereDoesntHave('roles', function (Builder $query) {
            $query->where('name', RolesUsersEnum::SUPER_ADMIN);
        })->whereNot('id', \Auth::user()->id)->paginate(10);
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
        return User::whereHas('cinemas', function ($query) use ($cinemaId) {
            $query->where('cinema_id', $cinemaId);
        })
            ->where('id', '!=', $authUser->id)
            ->paginate(10);
    }

    /*
     * Searching for a user by ID
     */
    public function getUserByIdOrFail(int $userId): User
    {
        return User::findOrFail($userId);
    }

    /*
     * Changing user information
     */
    public function updateInfoByUser($requestDTO, User $user): bool
    {
        return $user->update([
            'name' => $requestDTO->getName(),
            'email' => $requestDTO->getEmail(),
            'phone' => $requestDTO->getPhone(),
        ]);
    }

    /*
     * Changing the user password
     */
    public function updatePasswordByUser($requestDTO, User $user): bool
    {
        return $user->update([
            'password' => $requestDTO->getPassword()
        ]);
    }

    /*
     * Adding the selected role to a user
     */
    public function addRoleByUser(User $user, RolesUsersEnum $role): User
    {
        return $user->assignRole($role->value);
    }

    /*
     * Removing all user roles
     */
    public function deleteAllRoleByUser(User $user): User
    {
        return $user->syncRoles([]);
    }

    public function deleteRoleByUser(User $user, RolesUsersEnum $role): User
    {
        return $user->removeRole($role);
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
     * @param string $role
     * @return void
     */
    public function assignRoleToUser(User $user, string $role): void
    {
        $user->assignRole($role);
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
