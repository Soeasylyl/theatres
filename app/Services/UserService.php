<?php

namespace App\Services;

use App\DTO\Users\CreateUserDTO;
use App\DTO\Users\DeleteUserDTO;
use App\DTO\Users\EditUserDTO;
use App\DTO\Users\UpdateUserInfoDTO;
use App\DTO\Users\UpdateUserPasswordDTO;
use App\DTO\Users\UpdateUserRoleDTO;
use App\Enums\RolesUsersEnum;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Interfaces\CinemaRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;


class UserService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
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
        $authUserId = auth()->user()->id;

        if ($authUser->hasRole(RolesUsersEnum::SUPER_ADMIN->value)) {
            return $this->userRepository->getUsersWithoutAdminRolePaginatedList($authUserId);
        }

        return $this->userRepository->getUsersByCinemaPaginatedList($authUser->cinemas->pluck('id'), $authUserId);
    }

    /**
     * Creating a user
     *
     * @param CreateUserDTO $requestDTO
     * @return void
     */
    public function createUser(CreateUserDTO $requestDTO): void
    {
        $user = $this->userRepository->createUser($requestDTO);

        if ($requestDTO->getCinemaId()) {
            $this->userRepository->attachUserToCinema($user, $requestDTO->getCinemaId());
        }

        if ($roleId = $requestDTO->getRole()) {
            $user->assignRole($roleId);
        }
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
        $userRole = auth()->user()->roles->first();
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
        $authUser = auth()->user();

        try {
            $this->checkAdminEditingPermission($user, $authUser);
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
     * @return RedirectResponse
     */
    public function updatePasswordByUser(UpdateUserPasswordDTO $requestDTO): RedirectResponse
    {
        $user = $this->userRepository->getUserByIdOrFail($requestDTO->getUserId());
        $authUser = auth()->user();

        try {
            $this->checkAdminEditingPermission($user, $authUser);

            if ($requestDTO->getCurrentPassword() && !Hash::check($requestDTO->getCurrentPassword(), $user->password)) {
                return redirect()->back()->with('password_error', 'Текущий пароль неверен.');
            }

            $this->userRepository->updatePasswordByUser($requestDTO, $user);

            return redirect()->route('user.edit', $user->id)->with('success_update_user_password', 'Пароль успешно изменён.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
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
        $authUser = auth()->user();

        try {
            $this->checkAdminEditingPermission($user, $authUser);
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
     * @return RedirectResponse
     */
    public function updateUserRole(UpdateUserRoleDTO $requestDTO): RedirectResponse
    {
        $user = $this->userRepository->getUserByIdWithRolesOrFail($requestDTO->getUserId());
        $role = RolesUsersEnum::tryFrom($requestDTO->getRole());
        $authUser = auth()->user();
        $hasCinemaAdminRole = $authUser->hasRole(RolesUsersEnum::CINEMA_ADMIN);

        try {

            $this->checkAdminEditingPermission($user, $authUser);

            if ($role === null) {
                $user->syncRoles([]);;

                return redirect()->back()->with('success_update_role', 'Роль у пользователя успешно удалена.');
            }

            if ($hasCinemaAdminRole && $role == RolesUsersEnum::CINEMA_ADMIN) {
                return redirect()->back()->with('error_role', 'Администратор не может давать роль администратора.');
            }

            if ($user->roles->first() !== null) {
                $user->removeRole($user->roles->first()->name);        //deleting the current user role
            }

            $user->assignRole($role->value);

            return redirect()->back()->with('success_update_role', 'Роль у пользователя успешно изменена.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
