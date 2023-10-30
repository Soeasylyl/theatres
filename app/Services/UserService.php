<?php

namespace App\Services;

use App\DTO\Users\CreateUserDTO;
use App\DTO\Users\DeleteUserDTO;
use App\DTO\Users\UpdateUserInfoDTO;
use App\DTO\Users\UpdateUserPasswordDTO;
use App\DTO\Users\UpdateUserRoleDTO;
use App\Enums\RolesUsersEnum;
use App\Models\User;
use App\Repositories\Interfaces\CinemaRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;


class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface   $userRepository,
        private readonly CinemaRepositoryInterface $cinemaRepository,
    )
    {
    }

    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getUsersByRole(): LengthAwarePaginator
    {
        $authUser = auth()->user();
        $authUserId = $authUser->id;

        if ($authUser->hasRole(RolesUsersEnum::SUPER_ADMIN->value)) {
            return $this->userRepository->getUsersWithoutAdminRolePaginatedList($authUserId);
        }

        return $this->userRepository->getUsersByCinemaPaginatedList($authUser->cinemas->pluck('id'), $authUserId);
    }

    /**
     * Creating a user
     *
     * @param CreateUserDTO $requestDTO
     * @return User
     */
    public function createUser(CreateUserDTO $requestDTO): User
    {
        $user = $this->userRepository->createUser($requestDTO);

        if ($requestDTO->getCinemaId()) {
            $this->userRepository->attachUserToCinema($user, $requestDTO->getCinemaId());
        }

        if ($roleName = $requestDTO->getRoleName()) {
            $user->assignRole($roleName);
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
        $user = $this->userRepository->getUserByIdOrFail($editUserDTO->getUserId());
        $userRole = $editUserDTO->getAuthUser()->roles->first();
        $cinemas = $this->cinemaRepository->getCinemasPaginateList();

        return compact('user', 'userRole', 'cinemas');
    }

    /**
     * Updating user information
     *
     * @param UpdateUserInfoDTO $requestDTO
     * @return string
     */
    public function updateInfoByUser(UpdateUserInfoDTO $requestDTO): string
    {
        $user = $this->userRepository->getUserByIdOrFail($requestDTO->getUserId());

        try {
            $this->checkAdminEditingPermission($user, $requestDTO->getAuthUser());
            $this->userRepository->updateInfoByUser($requestDTO, $user);

            return 'Информация о пользователе успешно обновлена.';
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
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
        $user = $this->userRepository->getUserByIdOrFail($requestDTO->getUserId());

        if ($requestDTO->getShouldSkipPermissionCheck()) {
            $this->checkAdminEditingPermission($user, $requestDTO->getAuthUser());
        }

        if ($requestDTO->getCurrentPassword() && !Hash::check($requestDTO->getCurrentPassword(), $user->password)) {
            throw new \Exception('Текущий пароль неверен.');
        }

        $this->userRepository->updatePasswordByUser($requestDTO, $user);

        return $user;
    }

    /**
     * Checking that the administrator does not change data for another administrator
     *
     * @param User $user
     * @param User $authUser
     * @return void
     * @throws \Exception
     */
    private function checkAdminEditingPermission(User $user, User $authUser): void
    {
        $hasCinemaAdminRole = $authUser->hasRole(RolesUsersEnum::CINEMA_ADMIN->value);
        $currentUserHasCinemaAdminRole = $user->hasRole(RolesUsersEnum::CINEMA_ADMIN->value);

        if ($hasCinemaAdminRole && $currentUserHasCinemaAdminRole) {
            throw new \Exception('Невозможно изменить данные другого администратора.');
        }
    }

    /**
     * Deleting a user
     *
     * @param DeleteUserDTO $deleteUserDTO
     * @return string
     */
    public function deleteUser(DeleteUserDTO $deleteUserDTO): string
    {
        $user = $this->userRepository->getUserByIdOrFail($deleteUserDTO->getUserId());

        try {
            $this->checkAdminEditingPermission($user, $deleteUserDTO->getAuthUser());
            $user->delete();

            return 'Пользователь успешно удален.';
        } catch (\Throwable $e) {
            return $e->getMessage();
        }
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
        $user = $this->userRepository->getUserByIdWithRolesOrFail($requestDTO->getUserId());
        $role = RolesUsersEnum::tryFrom($requestDTO->getRole());
        $hasCinemaAdminRole = $requestDTO->getAuthUser()->hasRole(RolesUsersEnum::CINEMA_ADMIN);

        $this->checkAdminEditingPermission($user, $requestDTO->getAuthUser());

        if ($role === null) {
            $user->syncRoles([]);;

            return $user;
        }

        if ($hasCinemaAdminRole && $role == RolesUsersEnum::CINEMA_ADMIN) {
            throw new \Exception('Администратор не может давать роль администратора.');
        }

        if ($user->roles->first() !== null) {
            $user->removeRole($user->roles->first()->name);        //deleting the current user role
        }

        $user->assignRole($role->value);

        return $user;
    }
}
