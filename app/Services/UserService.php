<?php

namespace App\Services;

use App\DTO\Users\BanUserDTO;
use App\DTO\Users\CreateUserDTO;
use App\DTO\Users\DeleteUserDTO;
use App\DTO\Users\SearchUserDTO;
use App\DTO\Users\UpdateUserInfoDTO;
use App\DTO\Users\UpdateUserPasswordDTO;
use App\DTO\Users\UpdateUserRoleDTO;
use App\Enums\RolesUsersEnum;
use App\Models\User;
use App\Repositories\Interfaces\CinemaRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    /**
     * @param UserRepositoryInterface $userRepository
     * @param CinemaRepositoryInterface $cinemaRepository
     */
    public function __construct(
        private readonly UserRepositoryInterface   $userRepository,
        private readonly CinemaRepositoryInterface $cinemaRepository,
    )
    {
    }

    /**
     * Retrieve a paginated list of users based on the authenticated user's role and other criteria.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function fetchUsersForRole(SearchUserDTO $searchUserDTO): LengthAwarePaginator
    {
        if ($searchUserDTO->getProducer()->hasRole(RolesUsersEnum::SUPER_ADMIN->value)) {
            return $this->userRepository->getUsersWithoutAdminRolePaginatedList(
                authUserId: $searchUserDTO->getProducer()->id,
                searchTerm: $searchUserDTO->getSearchTerm(),
                relations: ['roles']
            );
        }

        return $this->userRepository->getUsersByCinemaPaginatedList(
            cinemaIds: $searchUserDTO->getProducer()->cinemas->pluck('id'),
            authUserId: $searchUserDTO->getProducer()->id,
            searchTerm: $searchUserDTO->getSearchTerm()
        );
    }

    /**
     * Creating a user
     *
     * @param CreateUserDTO $requestDTO
     * @return User
     */
    public function createUser(CreateUserDTO $requestDTO): User
    {
        $user = $this->userRepository->createUser(requestDTO: $requestDTO);

        if ($requestDTO->getCinemaId()) {
            $this->userRepository->attachUserToCinema(
                user: $user,
                cinemaId: $requestDTO->getCinemaId()
            );
        }

        if ($roleName = $requestDTO->getRoleName()) {
            $user->assignRole(roles: $roleName);
        }

        Log::info('User created: ' . $user->id);

        return $user;
    }

    /**
     *Retrieves user data for the purpose of editing.
     *
     * @param $editUserDTO
     * @return array
     */
    public function getUserDataForEdit($editUserDTO): array
    {
        $user = $this->userRepository->getUserByIdOrFail(userId: $editUserDTO->getUserId());
        $userCinemasList = $user->cinemas;
        $userRole = $editUserDTO->getProducer()->roles->first();
        $cinemas = $this->cinemaRepository->getCinemasPaginateList();

        return compact('user', 'userRole', 'cinemas', 'userCinemasList');
    }

    /**
     * Updating user information
     *
     * @param UpdateUserInfoDTO $requestDTO
     * @return string
     * @throws \Exception
     */
    public function updateInfoByUser(UpdateUserInfoDTO $requestDTO): string
    {
        $user = $this->userRepository->getUserByIdOrFail(userId: $requestDTO->getUserId());

        if ($requestDTO->isShouldRunPermissionCheck()) {
            $this->checkAdminEditingPermission(user: $user, producer: $requestDTO->getProducer());
        }

        $this->userRepository->updateInfoByUser(requestDTO: $requestDTO, user: $user);

        Log::info('User info updated: ' . $user->id);

        return $user;
    }

    /**
     * Password update
     *
     * @param UpdateUserPasswordDTO $requestDTO
     * @return User
     * @throws \Exception
     */
    public function updatePasswordByUser(UpdateUserPasswordDTO $requestDTO): User
    {
        $user = $this->userRepository->getUserByIdOrFail(userId: $requestDTO->getUserId());

        if ($requestDTO->isShouldRunPermissionCheck()) {
            $this->checkAdminEditingPermission(user: $user, producer: $requestDTO->getProducer());
        }

        if ($requestDTO->getCurrentPassword() && !Hash::check(
                value: $requestDTO->getCurrentPassword(),
                hashedValue: $user->password)
        ) {
            throw new \Exception('Текущий пароль неверен.');
        }

        $this->userRepository->updatePasswordByUser(requestDTO: $requestDTO, user: $user);

        return $user;
    }

    /**
     * Checking that the administrator does not change data for another administrator
     *
     * @param User $user
     * @param User $producer
     * @return void
     * @throws \Exception
     */
    private function checkAdminEditingPermission(User $user, User $producer): void
    {
        $hasCinemaAdminRole = $producer->hasRole(roles: RolesUsersEnum::CINEMA_ADMIN->value);
        $currentUserHasCinemaAdminRole = $user->hasRole(roles: RolesUsersEnum::CINEMA_ADMIN->value);

        if ($hasCinemaAdminRole && $currentUserHasCinemaAdminRole) {
            throw new \Exception('Невозможно изменить данные другого администратора.');
        }
    }

    /**
     * Deleting a user
     *
     * @param DeleteUserDTO $deleteUserDTO
     * @throws \Exception
     */
    public function deleteUser(DeleteUserDTO $deleteUserDTO): void
    {
        $user = $this->userRepository->getUserByIdOrFail(userId: $deleteUserDTO->getUserId());
        $this->checkAdminEditingPermission(user: $user, producer: $deleteUserDTO->getProducer());

        Log::info('User deleted: ' . $user->id);

        $user->delete();
    }

    /**
     *  Changing user roles
     *
     * @param UpdateUserRoleDTO $requestDTO
     * @return User
     * @throws \Exception
     */
    public function updateUserRole(UpdateUserRoleDTO $requestDTO): User
    {
        $user = $this->userRepository->getUserByIdOrFail(
            userId: $requestDTO->getUserId(),
            relations: ['roles'],
        );
        $role = RolesUsersEnum::tryFrom(value: $requestDTO->getRoleName());
        $hasCinemaAdminRole = $requestDTO->getProducer()->hasRole(roles: RolesUsersEnum::CINEMA_ADMIN);

        $this->checkAdminEditingPermission(
            user: $user,
            producer: $requestDTO->getProducer(),
        );

        if ($role === null) {
            $user->syncRoles([]);;

            return $user;
        }

        if ($hasCinemaAdminRole && $role == RolesUsersEnum::CINEMA_ADMIN) {
            throw new \Exception('Администратор не может давать роль администратора.');
        }

        if ($user->roles->first() !== null) {
            $user->removeRole(role: $user->roles->first()->name);        //deleting the current user role
        }

        $user->assignRole(roles: $role->value);

        return $user;
    }

    /**
     * Ban a user based on the provided BanUserDTO object and returns the user object after blocking.
     *
     * @param BanUserDTO $banUserDTO
     * @return User
     * @throws \Exception
     */
    public function blockUser(BanUserDTO $banUserDTO): User
    {
        $user = $this->userRepository->getUserByIdOrFail(userId: $banUserDTO->getUserId());
        $this->checkAdminEditingPermission(user: $user, producer: $banUserDTO->getProducer());
        $this->userRepository->blockUser(user: $user, date: $banUserDTO->getExpirationDate());

        Log::info('User blocked: ' . $user->id);

        return $user;
    }
}
