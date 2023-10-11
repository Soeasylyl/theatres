<?php

namespace App\Http\Controllers\Admin;


use App\Enums\RolesUsersEnum;
use App\Http\Requests\AdminProfilePasswordRequest;
use App\Http\Requests\UserProfileUpdateInfoRequest;
use App\Http\Requests\UserProfileUpdateRoleRequest;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseAdminController
{
    private $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository =$userRepository;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // Obtaining information about all users except authorized and super administrator
    public function index()
    {
        $users = $this->userRepository->getAllUsers();

        return view('admin.pages.users.main', compact('users'));
    }

    // Retrieving information to display on the selected user's page
    public function edit(int $userId)
    {
        $user = $this->userRepository->getUserById($userId);

        return view('admin.pages.users.edit', compact('user'));
    }

    // Updating information for the selected user
    public function updateInfo(UserProfileUpdateInfoRequest $request, User $user)
    {
        $this->userRepository->updateInfoByUser($request, $user);

        return redirect()->route('user.edit', $user->id)->with('success_update_user_info', 'Информация о пользователе успешно обновлена.');
    }

    // Updating the password for the selected user
    public function updatePassword(AdminProfilePasswordRequest $request, int $userId)
    {
        $user = $this->userRepository->getUserById($userId);

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->with('error', 'Текущий пароль неверен.');
        }

        $this->userRepository->updatePasswordByProfile($request, $user);

        return redirect()->route('user.edit', $user->id)->with('success', 'Пароль успешно изменён.');
    }

    // Delete a selected user
    public function delete(int $userId)
    {
        $user = $this->userRepository->getUserById($userId);
        $userRole = $this->userRepository->getRoleUser($user);
        $authUser = $this->userRepository->getAuthUser();
        $authUserRole = $this->userRepository->getRoleUser($authUser);

        if ($authUserRole->name == RolesUsersEnum::CINEMA_ADMIN->value && ($user->roles->isNotEmpty() && $userRole->name == RolesUsersEnum::CINEMA_ADMIN->value)) {
            return redirect()->back()->with('error_delete_user', 'Администратор не может удалить другого администратора.');
        }

        if ($authUserRole->name == RolesUsersEnum::CINEMA_MANAGER->value && ($user->roles->isNotEmpty() && $userRole->name == RolesUsersEnum::CINEMA_ADMIN->value)) {
            return redirect()->back()->with('error_delete_user', 'Менеджеры не может удалить другого администратора.');
        }

        if ($authUserRole->name == RolesUsersEnum::CINEMA_MANAGER->value && ($user->roles->isNotEmpty() && $userRole->name == RolesUsersEnum::CINEMA_MANAGER->value)) {
            return redirect()->back()->with('error_delete_user', 'Менеджеры не может удалить другого менеджера.');
        }

        $this->userRepository->deleteUser($user);

        return redirect()->route('users')->with('success_delete_user', 'Пользователь успешно удален.');
    }

    // Change the role of the selected user
    public function updateRole(UserProfileUpdateRoleRequest $request)
    {
        $user = $this->userRepository->getUserByRequest($request);
        $UserRole = $this->userRepository->getRoleUser($user);
        $authUser = $this->userRepository->getAuthUser();
        $authUserRole = $this->userRepository->getRoleUser($authUser);
        $roleNameRequest = $request->input('role');

        // Checking that only super-administrator and administrator can change roles
        if ($authUserRole->name == RolesUsersEnum::SUPER_ADMIN->value || $authUserRole->name == RolesUsersEnum::CINEMA_ADMIN->value) {

            if ($authUserRole->name == RolesUsersEnum::CINEMA_ADMIN->value && ($user->roles->isNotEmpty() && $UserRole->name == RolesUsersEnum::CINEMA_ADMIN->value)) {
                return redirect()->back()->with('error_role', 'Администратор не может изменять роль другому администратору.');
            }

            if ($authUserRole->name == RolesUsersEnum::CINEMA_ADMIN->value && $roleNameRequest == RolesUsersEnum::CINEMA_ADMIN->value) {
                return redirect()->back()->with('error_role', 'Администратор не может давать роль администратора.');
            }

            if ($authUserRole->name == RolesUsersEnum::CINEMA_MANAGER->value) {
                return redirect()->back()->with('error_role', 'Менеджеры не могут изменять роли.');
            }

            if ($roleNameRequest === null) {
                $this->userRepository->deleteAllRoleByUser($user);
                return redirect()->back()->with('success_update_role', 'Роль у пользователя успешно удалена.');
            } else {

                if ($UserRole) {
                    $this->userRepository->deleteRoleByUser($user, $UserRole);        //deleting the current user role
                }

                $this->userRepository->addRoleByUser($user, $roleNameRequest);

                return redirect()->back()->with('success_update_role', 'Роль у пользователя успешно изменена.');
            }
        } else {
            return redirect()->back()->with('error_role', 'Недостатоно прав для изменения ролей.');
        }
    }
}
