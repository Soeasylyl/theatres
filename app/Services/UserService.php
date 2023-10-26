<?php

namespace App\Services;

use App\DTO\Users\CreateDTO;
use App\DTO\Users\UpdateInfoDTO;
use App\DTO\Users\UpdatePasswordDTO;
use App\DTO\Users\UpdateRoleDTO;
use App\Enums\RolesUsersEnum;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;


class UserService
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    /**
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    public function getUsersByRole(): LengthAwarePaginator
    {
        $authUser = auth()->user();
        if ($authUser->hasRole(RolesUsersEnum::SUPER_ADMIN->value)) {
            return $this->userRepository->getAllUsers();
        }

        return $this->userRepository->getUsersByCinema($authUser->cinemas->pluck('id'), $authUser);
    }

    /**
     * Creating a user
     *
     * @param CreateDTO $requestDTO
     * @return RedirectResponse
     */
    public function createUser(CreateDTO $requestDTO): RedirectResponse
    {
        $user = $this->userRepository->createUser($requestDTO);

        if ($requestDTO->getCinemaId()) {
            $this->userRepository->attachUserToCinema($user, $requestDTO->getCinemaId());
        }

        if ($roleId = $requestDTO->getRole()) {
            $user->assignRole($roleId);
        }

        return redirect()->route('users')->with('success_create_user', 'Пользователь успешно создан');
    }

    /**
     * Updating user information
     *
     * @param UpdateInfoDTO $requestDTO
     * @return RedirectResponse
     */
    public function updateInfoByUser(UpdateInfoDTO $requestDTO): RedirectResponse
    {
        $user = $this->userRepository->getUserByIdOrFail($requestDTO->getUserId());

        try {
            $this->checkAdminEditingPermission($user);
            $this->userRepository->updateInfoByUser($requestDTO, $user);

            return redirect()->route('user.edit', $user->id)->with('success_update_user_info', 'Информация о пользователе успешно обновлена.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Password update
     *
     * @param UpdatePasswordDTO $requestDTO
     * @return RedirectResponse
     */
    public function updatePasswordByUser(UpdatePasswordDTO $requestDTO): RedirectResponse
    {
        $user = $this->userRepository->getUserByIdOrFail($requestDTO->getUserId());

        try {
            $this->checkAdminEditingPermission($user);

            if ($requestDTO->getCurrentPassword() && !Hash::check($requestDTO->getCurrentPassword(), $user->password)) {
                return redirect()->back()->with('password_error', 'Текущий пароль неверен.');
            }

            $this->userRepository->updatePasswordByUser($requestDTO, $user);

            return redirect()->route('user.edit', $user->id)->with('success_update_user_password', 'Пароль успешно изменён.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Checking that the administrator does not change data for another administrator
     *
     * @param User $user
     * @return void
     * @throws \Exception
     */
    private function checkAdminEditingPermission(User $user): void
    {
        $hasCinemaAdminRole = auth()->user()->hasRole(RolesUsersEnum::CINEMA_ADMIN->value);
        $currentUserHasCinemaAdminRole = $user->hasRole(RolesUsersEnum::CINEMA_ADMIN->value);

        if ($hasCinemaAdminRole && $currentUserHasCinemaAdminRole) {
            throw new \Exception('Невозможно изменить данные другого администратора.');
        }
    }

    /**
     * Deleting a user
     *
     * @param int $userId
     * @return RedirectResponse
     */
    public function deleteUser(int $userId): RedirectResponse
    {
        $user = $this->userRepository->getUserByIdOrFail($userId);

        try {
            $this->checkAdminEditingPermission($user);
            $user->delete();

            return redirect()->route('users')->with('success_delete_user', 'Пользователь успешно удален.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     *  Сhanging user roles
     *
     * @param UpdateRoleDTO $requestDTO
     * @return RedirectResponse
     */
    public function updateUserRole(UpdateRoleDTO $requestDTO): RedirectResponse
    {
        $user = $this->userRepository->getUserByIdOrFail($requestDTO->getUserId());
        $roleName = $requestDTO->getRole();
        $hasCinemaAdminRole = auth()->user()->hasRole(RolesUsersEnum::CINEMA_ADMIN->value);

        try {
            $this->checkAdminEditingPermission($user);

            if ($hasCinemaAdminRole && $roleName == RolesUsersEnum::CINEMA_ADMIN->value) {
                return redirect()->back()->with('error_role', 'Администратор не может давать роль администратора.');
            }

            if ($roleName === null) {
                $this->userRepository->deleteAllRoles($user);

                return redirect()->back()->with('success_update_role', 'Роль у пользователя успешно удалена.');
            }

            if ($user->roles->first()) {
                $role = RolesUsersEnum::from($user->roles->first()->name);
                $user->removeRole($role);        //deleting the current user role
            }

            $role = RolesUsersEnum::from($roleName);
            $this->userRepository->addRoleByUser($user, $role);

            return redirect()->back()->with('success_update_role', 'Роль у пользователя успешно изменена.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
