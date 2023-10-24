<?php

namespace App\Repositories\Interfaces;

use App\DTO\Users\CreateUserDTO;
use App\Enums\RolesUsersEnum;
use app\Models\User;

interface UserRepositoryInterface
{
    /**
     * Obtaining information about all users except authorized and super administrator
     *
     * @return mixed
     */
    public function getAllUsers(): mixed;

    /**
     * Receiving all users from one cinema, except the authorized one
     *
     * @param $cinemaId
     * @param User $authUser
     * @return mixed
     */
    public function getUsersByCinema($cinemaId, User $authUser): mixed;

    /**
     * Searching for a user by ID
     *
     * @param int $user
     * @return mixed
     */
    public function getUserByIdOrFail(int $user): mixed;

    /**
     * Changing user information
     *
     * @param $requestDTO
     * @param User $user
     * @return mixed
     */
    public function updateInfoByUser($requestDTO, User $user): mixed;

    /**
     * Changing the user password
     *
     * @param $requestDTO
     * @param User $user
     * @return mixed
     */
    public function updatePasswordByUser($requestDTO, User $user): mixed;

    /**
     * Adding the selected role to a user
     *
     * @param User $user
     * @param RolesUsersEnum $role
     * @return mixed
     */
    public function addRoleByUser(User $user, RolesUsersEnum $role): mixed;

    /**
     * Removing all user roles
     *
     * @param User $user
     * @return mixed
     */
    public function deleteAllRoleByUser(User $user): mixed;

    /**
     * Removing a user role
     *
     * @param User $user
     * @param RolesUsersEnum $role
     * @return mixed
     */
    public function deleteRoleByUser(User $user, RolesUsersEnum $role): mixed;

    /**
     * @param CreateUserDTO $requestDTO
     * @return mixed
     */
    public function createUser(CreateUserDTO $requestDTO): mixed;

    /**
     * @param User $user
     * @param string $role
     * @return void
     */
    public function assignRoleToUser(User $user, string $role): void;

    /**
     * @param User $user
     * @param int $cinemaId
     * @return void
     */
    public function attachUserToCinema(User $user, int $cinemaId): void;

    /**
     * @param $userId
     * @param $requestedUserCinemas
     * @return bool
     */
    public function checkUserCinemas($userId, $requestedUserCinemas): bool;
}
