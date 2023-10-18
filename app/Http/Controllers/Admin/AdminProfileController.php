<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RolesUsersEnum;
use App\Http\Requests\AdminProfileInfoRequest;
use App\Http\Requests\AdminProfilePasswordRequest;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;


class AdminProfileController extends BaseAdminController
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
        $this->middleware('auth');
    }

    /**
     *  Get authorized user information + role
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function profile()
    {
        $user = auth()->user();  //* Getting the current authorized user
        $userRole = $user->roles->first();

        return view('admin.pages.users.profile', compact('user', 'userRole'));
    }

    /**
     * Updating information for an authorized user
     *
     * @param AdminProfileInfoRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateInfo(AdminProfileInfoRequest $request)
    {
        $user = auth()->user();  //* Getting the current authorized user
        $this->userRepository->updateInfoByUser($request, $user);

        return redirect()->route('admin.profile', $user->id)->with('success_update_profile_info', 'Информация о пользователе успешно обновлена.');
    }

    /**
     * Updating the password for an authorized user
     *
     * @param AdminProfilePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(AdminProfilePasswordRequest $request)
    {
        $user = auth()->user();  //* Getting the current authorized user

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->with('error', 'Текущий пароль неверен.');
        }

        $this->userRepository->updatePasswordByProfile($request, $user);

        return redirect()->route('admin.profile', $user->id)->with('success_update_profile_password', 'Пароль успешно изменен.');
    }
}
