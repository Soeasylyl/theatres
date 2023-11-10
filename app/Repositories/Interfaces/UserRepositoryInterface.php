<?php

namespace App\Repositories\Interfaces;

use App\DTO\Users\CreateUserDTO;
use App\DTO\Users\UpdateUserInfoDTO;
use App\DTO\Users\UpdateUserPasswordDTO;
use app\Models\User;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface UserRepositoryInterface
{
    /**
     * Obtaining information about all users except authorized and super administrator
     *
     * @param int $authUserId
     * @param string $searchTerm
     * @param array|null $relations
     * @return LengthAwarePaginator
     */
    public function getUsersWithoutAdminRolePaginatedList(int $authUserId, string $searchTerm, ?array $relations = []):  LengthAwarePaginator;

    /**
     * Receiving all users from one cinema, except the authorized one
     *
     * @param Collection $cinemaIds
     * @param int $authUserId
     * @param string $searchTerm
     * @return LengthAwarePaginator
     */
    public function getUsersByCinemaPaginatedList(Collection $cinemaIds, int $authUserId, string $searchTerm): LengthAwarePaginator;

    /**
     * Searching for a user by ID
     *
     * @param int $userId
     * @param array|null $relations
     * @return User
     */
    public function getUserByIdOrFail(int $userId, ?array $relations = []): User;

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
     * Create a new user based on the provided CreateUserDTO.
     *
     * @param CreateUserDTO $requestDTO
     * @return User
     */
    public function createUser(CreateUserDTO $requestDTO): User;

    /**
     * Attach a user to a cinema.
     *
     * @param User $user
     * @param int $cinemaId
     * @return void
     */
    public function attachUserToCinema(User $user, int $cinemaId): void;

    /**
     * Blocks the user for a certain amount of time.
     *
     * @param User $user
     * @param Carbon $date
     * @return User
     */
    public function blockUser(User $user, Carbon $date): User;
}
