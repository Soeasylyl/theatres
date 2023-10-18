<?php

namespace App\Repositories\Interfaces;

use app\Models\User;
use Spatie\Permission\Models\Role;

interface UserRepositoryInterface
{
    /*
     * Obtaining information about all users except authorized and super administrator
     */
    public function getAllUsers();

    /*
     * Searching for a user by ID
     */
    public function getUserByIdOrFail(int $user);

    /*
     * Search for a user by request
     */
    public function getUserByRequestOrFail($request);

    /*
     * Changing user information
     */
    public function updateInfoByUser($request, User $user);

    /*
     * Changing the user password
     */
    public function updatePasswordByProfile($request, User $user);

    /*
     * Adding the selected role to a user
     */
    public function addRoleByUser (User $user, $roleName);

    /*
     * Removing all user roles
     */
    public function deleteAllRoleByUser (User $user);

    /*
     * Removing a user role
     */
    public function deleteRoleByUser (User $user, $userRole);
}
