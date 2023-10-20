<?php

namespace App\Repositories\Interfaces;

use App\DTO\Users\UserDTO;
use app\Models\User;

interface UserRepositoryInterface
{
    /**
     * Obtaining information about all users except authorized and super administrator
     *
     * @return mixed
     */
    public function getAllUsers();

    /**
     * Searching for a user by ID
     *
     * @param int $user
     * @return mixed
     */
    public function getUserByIdOrFail(int $user);

    /**
     * Search for a user by request
     *
     * @param $requestDTO
     * @return mixed
     */
    public function getUserByRequestOrFail($requestDTO);

    /**
     * Changing user information
     *
     * @param $requestDTO
     * @param User $user
     * @return mixed
     */
    public function updateInfoByUser($requestDTO, User $user);

    /**
     * Changing the user password
     *
     * @param $requestDTO
     * @param User $user
     * @return mixed
     */
    public function updatePasswordByUser($requestDTO, User $user);

    /**
     * Adding the selected role to a user
     *
     * @param User $user
     * @param $roleName
     * @return mixed
     */
    public function addRoleByUser (User $user, $roleName);

    /**
     * Removing all user roles
     *
     * @param User $user
     * @return mixed
     */
    public function deleteAllRoleByUser (User $user);

    /**
     * Removing a user role
     *
     * @param User $user
     * @param $userRole
     * @return mixed
     */
    public function deleteRoleByUser (User $user, $userRole);

    /**
     * @param UserDTO $requestDTO
     * @return mixed
     */
    public function createUser (UserDTO $requestDTO);

    /**
     * @param User $user
     * @param string $role
     * @return mixed
     */
    public function assignRoleToUser(User $user, string $role);

    /**
     * @param User $user
     * @param int $cinemaId
     * @return mixed
     */
    public function attachUserToCinema(User $user, int $cinemaId);
}
