<?php

namespace App\Repositories\Interfaces;

use App\DTO\Users\CreateUserDTO;
use App\DTO\Users\UpdateUserInfoDTO;
use App\DTO\Users\UpdateUserPasswordDTO;
use app\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    /**
     * Obtaining information about all users except authorized and super administrator
     *
     * @param int $authUserId
     * @return LengthAwarePaginator
     */
    public function getUsersWithoutAdminRolePaginatedList(int $authUserId): LengthAwarePaginator;

    /**
     * Receiving all users from one cinema, except the authorized one
     *
     * @param Collection $cinemaIds
     * @param int $authUserId
     * @return LengthAwarePaginator
     */
    public function getUsersByCinemaPaginatedList(Collection $cinemaIds, int $authUserId): LengthAwarePaginator;

    /**
     * Searching for a user by ID
     *
     * @param int $userId
     * @param array|null $relations
     * @return User
     */
    public function getUserByIdOrFail(int $userId, ?array $relations = []): User;

    /**
     * Searching for a user by ID with roles
     *
     * @param int $userId
     * @return User
     */
    public function getUserByIdWithRolesOrFail(int $userId): User;

    /**
     * Changing user information
     *
     * @param UpdateUserInfoDTO $requestDTO
     * @param User $user
     * @return User
     */
    public function updateInfoByUser(UpdateUserInfoDTO $requestDTO, User $user): User;

    /**
     * Changing the user password
     *
     * @param UpdateUserPasswordDTO $requestDTO
     * @param User $user
     * @return User
     */
    public function updatePasswordByUser(UpdateUserPasswordDTO $requestDTO, User $user): User;

    /**
     * @param CreateUserDTO $requestDTO
     * @return User
     */
    public function createUser(CreateUserDTO $requestDTO): User;

    /**
     * @param User $user
     * @param int $cinemaId
     * @return void
     */
    public function attachUserToCinema(User $user, int $cinemaId): void;
}
