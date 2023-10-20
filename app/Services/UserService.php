<?php

namespace App\Services;

use App\DTO\Users\UserDTO;
use App\DTO\Users\UserUpdateCinemaDTO;
use App\DTO\Users\UserUpdateInfoDTO;
use App\DTO\Users\UserUpdatePasswordDTO;
use App\DTO\Users\UserUpdateRoleDTO;
use App\Enums\RolesUsersEnum;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;


class UserService
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    /**
     * Creating a user
     *
     * @param UserDTO $requestDTO
     * @return RedirectResponse
     */
    public function createUser(UserDTO $requestDTO): RedirectResponse
    {
        if (!auth()->user()->hasRole(RolesUsersEnum::SUPER_ADMIN->value) && (!auth()->user()->hasRole(RolesUsersEnum::CINEMA_ADMIN->value))) {

            return redirect()->back()->with('error', 'Пользователей может добавлять только Администратор');
        }

        $user = $this->userRepository->createUser($requestDTO);

        if ($requestDTO->getCinemaId()) {
            $this->userRepository->attachUserToCinema($user, $requestDTO->getCinemaId());
        }

        if ($roleId = $requestDTO->getRole()) {
            $this->userRepository->assignRoleToUser($user, $roleId);
        }

        return redirect()->route('users')->with('success_create_user', 'Пользователь успешно создан');
    }

    /**
     * Updating user information
     *
     * @param UserUpdateInfoDTO $requestDTO
     * @param User $user
     * @return RedirectResponse|void
     */
    public function updateInfoByUser (UserUpdateInfoDTO $requestDTO, User $user)
    {
        if (auth()->user()->hasRole(RolesUsersEnum::CINEMA_MANAGER->value) && ($user->id === auth()->user()->id)) {
            $this->userRepository->updateInfoByUser($requestDTO, $user);

            return redirect()->route('user.edit', $user->id)->with('success_update_user_info', 'Информация о пользователе успешно обновлена.');
        }

        if (auth()->user()->hasRole(RolesUsersEnum::CINEMA_ADMIN->value) && ($user->id === auth()->user()->id)) {
            $this->userRepository->updateInfoByUser($requestDTO, $user);

            return redirect()->route('user.edit', $user->id)->with('success_update_user_info', 'Информация о пользователе успешно обновлена.');
        }

        if (!auth()->user()->hasRole(RolesUsersEnum::SUPER_ADMIN->value) && (!auth()->user()->hasRole(RolesUsersEnum::CINEMA_ADMIN->value))) {

            return redirect()->back()->with('password_error', 'Информацию о пользователях может изменять только Администратор');
        }

        if (auth()->user()->hasRole(RolesUsersEnum::CINEMA_ADMIN->value) && ($user->hasRole(RolesUsersEnum::CINEMA_ADMIN->value))) {

            return redirect()->back()->with('error', 'Администратор не может редактировать данные другому администратору.');
        }

        $this->userRepository->updateInfoByUser($requestDTO, $user);

        return redirect()->route('user.edit', $user->id)->with('success_update_user_info', 'Информация о пользователе успешно обновлена.');
    }

    /**
     * Password update
     *
     * @param UserUpdatePasswordDTO $requestDTO
     * @param int $userId
     * @return RedirectResponse
     */
    public function updatePasswordByUser (UserUpdatePasswordDTO $requestDTO, int $userId): RedirectResponse
    {
        $user = $this->userRepository->getUserByIdOrFail($userId);

        if (auth()->user()->hasRole(RolesUsersEnum::CINEMA_MANAGER->value) && ($user->id === auth()->user()->id)) {

            return $this->hashCheckUpdatePassword($requestDTO, $user);
        }

        if (auth()->user()->hasRole(RolesUsersEnum::CINEMA_ADMIN->value) && ($user->id === auth()->user()->id)) {

            return $this->hashCheckUpdatePassword($requestDTO, $user);
        }

        if (!auth()->user()->hasRole(RolesUsersEnum::SUPER_ADMIN->value) && (!auth()->user()->hasRole(RolesUsersEnum::CINEMA_ADMIN->value))) {

            return redirect()->back()->with('password_error', 'Информацию о пользователях может изменять только Администратор');
        }

        if (auth()->user()->hasRole(RolesUsersEnum::CINEMA_ADMIN->value) && ($user->hasRole(RolesUsersEnum::CINEMA_ADMIN->value))) {

            return redirect()->back()->with('password_error', 'Администратор не может изменить пароль другому администратору.');
        }

        return $this->hashCheckUpdatePassword($requestDTO, $user);
    }

    /**
     * Checking the current password and changing the password
     *
     * @param UserUpdatePasswordDTO $requestDTO
     * @param User $user
     * @return RedirectResponse
     */
    private function hashCheckUpdatePassword (UserUpdatePasswordDTO $requestDTO, User $user): RedirectResponse
    {
        if ($requestDTO->getCurrentPassword() && !Hash::check($requestDTO->getCurrentPassword(), $user->password)) {

            return redirect()->back()->with('password_error', 'Текущий пароль неверен.');
        }

        $this->userRepository->updatePasswordByUser($requestDTO, $user);

        return redirect()->route('user.edit', $user->id)->with('success_update_user_password', 'Пароль успешно изменён.');
    }

    /**
     * Deleting a user
     *
     * @param int $userId
     * @return RedirectResponse
     */
    public function deleteUser (int $userId): RedirectResponse
    {
        $user = $this->userRepository->getUserByIdOrFail($userId);

        if (!auth()->user()->hasRole(RolesUsersEnum::SUPER_ADMIN->value) && (!auth()->user()->hasRole(RolesUsersEnum::CINEMA_ADMIN->value))) {

            return redirect()->back()->with('error_delete_user', 'Удалять пользователей может только Администратор');
        }

        if (auth()->user()->hasRole(RolesUsersEnum::CINEMA_ADMIN->value) && ($user->hasRole(RolesUsersEnum::CINEMA_ADMIN->value))) {

            return redirect()->back()->with('error_delete_user', 'Администратор не может удалить другого администратора.');
        }

        $user->delete();

        return redirect()->route('users')->with('success_delete_user', 'Пользователь успешно удален.');
    }

    /**
     *  Сhanging user roles
     *
     * @param UserUpdateRoleDTO $requestDTO
     * @return RedirectResponse
     */
    public function updateRoleUser (UserUpdateRoleDTO $requestDTO): RedirectResponse
    {
        $user = $this->userRepository->getUserByRequestOrFail($requestDTO);
        $roleNameRequest = $requestDTO->getRole();

        if (auth()->user()->hasRole(RolesUsersEnum::SUPER_ADMIN->value) || auth()->user()->hasRole(RolesUsersEnum::CINEMA_ADMIN->value)) {

            if (auth()->user()->hasRole(RolesUsersEnum::CINEMA_ADMIN->value) && ($user->roles->isNotEmpty() && $user->hasRole(RolesUsersEnum::CINEMA_ADMIN->value))) {

                return redirect()->back()->with('error_role', 'Администратор не может изменять роль другому администратору.');
            }

            if (auth()->user()->hasRole(RolesUsersEnum::CINEMA_ADMIN->value) && $roleNameRequest == RolesUsersEnum::CINEMA_ADMIN->value) {

                return redirect()->back()->with('error_role', 'Администратор не может давать роль администратора.');
            }

            if (auth()->user()->hasRole(RolesUsersEnum::CINEMA_MANAGER->value)) {

                return redirect()->back()->with('error_role', 'Менеджеры не могут изменять роли.');
            }

            if ($roleNameRequest === null) {
                $this->userRepository->deleteAllRoleByUser($user);

                return redirect()->back()->with('success_update_role', 'Роль у пользователя успешно удалена.');
            } else {

                if ($user->roles->first()) {
                    $this->userRepository->deleteRoleByUser($user, $user->roles->first());        //deleting the current user role
                }

                $this->userRepository->addRoleByUser($user, $roleNameRequest);

                return redirect()->back()->with('success_update_role', 'Роль у пользователя успешно изменена.');
            }
        }
        else {

            return redirect()->back()->with('error_role', 'Недостатоно прав для изменения ролей.');
        }
    }

    /**
     * Updating information about the cinema to which the user belongs
     *
     * @param UserUpdateCinemaDTO $requestDTO
     * @return RedirectResponse
     */
    public function updateCinemaUser (UserUpdateCinemaDTO $requestDTO): RedirectResponse
    {
        $user = $this->userRepository->getUserByRequestOrFail($requestDTO);
        $cinemaIdRequest = $requestDTO->getCinema();

        if (auth()->user()->hasRole(RolesUsersEnum::SUPER_ADMIN->value) || auth()->user()->hasRole(RolesUsersEnum::CINEMA_ADMIN->value)) {
            if (auth()->user()->hasRole(RolesUsersEnum::CINEMA_ADMIN->value) && ($user->hasRole(RolesUsersEnum::CINEMA_ADMIN->value))) {

                return redirect()->back()->with('error_cinema', 'Администратор не может изменять кинотеатр другому администратору.');
            }

            if (auth()->user()->hasRole(RolesUsersEnum::CINEMA_MANAGER->value)) {

                return redirect()->back()->with('error_cinema', 'Менеджеры не могут изменять кинотеатры других пользователей.');
            }

            if ($cinemaIdRequest === null) {
                $user->cinemas()->detach();

                return redirect()->back()->with('success_update_cinema', 'Кинотеатр у пользователя успешно удален.');
            } else {
                $user->cinemas()->sync($cinemaIdRequest);

                return redirect()->back()->with('success_update_cinema', 'Кинотеатр у пользователя успешно изменен.');
            }
        } else {

            return redirect()->back()->with('error_cinema', 'Недостаточно прав для изменения кинотеатров.');
        }
    }
}
