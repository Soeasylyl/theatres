<?php

namespace App\Services;

use App\DTO\Users\BanUserTDO;
use App\DTO\Users\CreateUserDTO;
use App\DTO\Users\DeleteUserDTO;
use App\DTO\Users\UpdateUserInfoDTO;
use App\DTO\Users\UpdateUserPasswordDTO;
use App\DTO\Users\UpdateUserRoleDTO;
use App\Enums\RolesUsersEnum;
use App\Jobs\SendBanNotificationMail;
use App\Models\User;
use App\Repositories\Interfaces\CinemaRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

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
     * Retrieve a paginated list of users based on the authenticated user's role.
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getUsersByRole(): LengthAwarePaginator
    {
        $authUser = auth()->user();

        if ($authUser->hasRole(roles: RolesUsersEnum::SUPER_ADMIN->value)) {
            return $this->userRepository->getUsersWithoutAdminRolePaginatedList(
                authUserId: $authUser->id,
                relations: ['roles'],
            );
        }

        return $this->userRepository->getUsersByCinemaPaginatedList(
            cinemaIds: $authUser->cinemas->pluck('id'),
            authUserId: $authUser->id,
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
            $this->userRepository->attachUserToCinema(user: $user, cinemaId: $requestDTO->getCinemaId());
        }

        if ($roleName = $requestDTO->getRoleName()) {
            $user->assignRole(roles: $roleName);
        }

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
     * @param BanUserTDO $banUserTDO
     * @return User
     * @throws \Exception
     */
    public function blockUser(BanUserTDO $banUserTDO): User
    {
        $user = $this->userRepository->getUserByIdOrFail(userId: $banUserTDO->getUserId());
        $this->checkAdminEditingPermission(user: $user, producer: $banUserTDO->getProducer());
        $this->userRepository->blockUser(user: $user, date: $banUserTDO->getExpirationDate());

        return $user;
    }
}
