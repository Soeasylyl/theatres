<?php

namespace App\Repositories;



use App\DTO\Users\UserDTO;
use App\Enums\RolesUsersEnum;
use app\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;


class UserRepository implements UserRepositoryInterface
{
    /*
     * Obtaining information about all users except authorized and super administrator
     */
    public function getAllUsers()
    {
        return User::whereDoesntHave('roles', function (Builder $query) {
                $query->where('name', RolesUsersEnum::SUPER_ADMIN);
                })->whereNot('id', \Auth::user()->id)->get();
    }

    /*
     * Searching for a user by ID
     */
    public function getUserByIdOrFail(int $userId)
    {
        return User::findOrFail($userId);
    }

    /*
     * Search for a user by request
     */
    public function getUserByRequestOrFail($requestDTO): User
    {
        return User::findOrFail($requestDTO->getUserId());
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
            'password' => Hash::make($requestDTO->getPassword())
        ]);
    }

    /*
     * Adding the selected role to a user
     */
    public function addRoleByUser(User $user, $roleName)
    {
        return $user->assignRole($roleName);
    }

    /*
     * Removing all user roles
     */
    public function deleteAllRoleByUser(User $user)
    {
        return $user->syncRoles([]);
    }

   public function deleteRoleByUser(User $user, $userRole)
   {
       return $user->removeRole($userRole->name);
   }

    /**
     * @param UserDTO $userDTO
     * @return void
     */
   public function createUser(UserDTO $userDTO)
   {
       return User::create([
           'name' => $userDTO->getName(),
           'email' => $userDTO->getEmail(),
           'phone' => $userDTO->getPhone(),
           'password' => bcrypt($userDTO->getPassword()),
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
