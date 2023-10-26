<?php

namespace App\Repositories\Interfaces;

use App\DTO\Users\CreateDTO;
use App\Enums\RolesUsersEnum;
use app\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserRepositoryInterface
{
    /**
     * Obtaining information about all users except authorized and super administrator
     *
     * @return LengthAwarePaginator
     */
    public function getAllUsers(): LengthAwarePaginator;

    /**
     * Receiving all users from one cinema, except the authorized one
     *
     * @param $cinemaId
     * @param User $authUser
     * @return LengthAwarePaginator
     */
    public function getUsersByCinema($cinemaId, User $authUser): LengthAwarePaginator;

    /**
     * Searching for a user by ID
     *
     * @param int $userId
     * @param array|null $relations
     * @return mixed
     */
    public function getUserByIdOrFail(int $userId, ?array $relations = []): mixed;

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
    public function deleteAllRoles(User $user): mixed;

    /**
     * @param CreateDTO $requestDTO
     * @return mixed
     */
    public function createUser(CreateDTO $requestDTO): mixed;

    /**
     * @param User $user
     * @param int $cinemaId
     * @return void
     */
    public function attachUserToCinema(User $user, int $cinemaId): void;
}
