<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RolesUsersEnum;
use App\Http\Requests\AdminProfileInfoRequest;
use App\Http\Requests\AdminProfilePasswordRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;


class AdminProfileController extends BaseAdminController
{
    private $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository =$userRepository;
        $this->middleware('auth');
    }

    //* Get authorized user information + role
    public function profile()
    {
        $user = $this->userRepository->getAuthUser();  //* Getting the current authorized user

        $userRole = $this->userRepository->getRoleUser($user);

        return view('admin.pages.users.profile', compact('user', 'userRole'));
    }

    //* Updating information for an authorized user
    public function updateInfo(AdminProfileInfoRequest $request)
    {
        $user = $this->userRepository->getAuthUser();  //* Getting the current authorized user

        $this->userRepository->updateInfoByUser($request, $user);

        return redirect()->route('admin.profile', $user->id)->with('success_update_profile_info', 'Информация о пользователе успешно обновлена.');
    }

    //* Updating the password for an authorized user
    public function updatePassword(AdminProfilePasswordRequest $request)
    {
        $user = $this->userRepository->getAuthUser();  //* Getting the current authorized user

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->with('error', 'Текущий пароль неверен.');
        }

        $this->userRepository->updatePasswordByProfile($request, $user);

        return redirect()->route('admin.profile', $user->id)->with('success_update_profile_password', 'Пароль успешно изменен.');
    }

    //* Deleting an authorized user
    public function deleteProfile()
    {
        $user = $this->userRepository->getAuthUser();   //* Getting the current authorized user
        $role = $this->userRepository->getRoleUser($user);

        if ($role->name == RolesUsersEnum::CINEMA_ADMIN->value) {
            return redirect()->back()->with('error_delete_profile', 'Администратор не может удалить себя.');
        }

        $this->userRepository->deleteUser($user);

        return redirect()->route('users')->with('success', 'Пользователь успешно удален');
    }
}
