<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\AdminProfileInfoRequest;
use App\Http\Requests\AdminProfilePasswordRequest;
use Illuminate\Support\Facades\Hash;


class AdminProfileController extends BaseAdminController
{
    //* Get authorized user information + role
    public function profile()
    {
        $user = auth()->user();  //* Getting the current authorized user

        $userRole = $user->roles->first();

        return view('admin.pages.users.profile', compact('user', 'userRole'));
    }

    //* Updating information for an authorized user
    public function updateInfo(AdminProfileInfoRequest $request)
    {
        $user = auth()->user();  //* Getting the current authorized user

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);

        return redirect()->route('admin.profile', $user->id)->with('success_update_profile_info', 'Информация о пользователе успешно обновлена.');
    }

    //* Updating the password for an authorized user
    public function updatePassword(AdminProfilePasswordRequest $request)
    {
        $user = auth()->user();  //* Getting the current authorized user

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        $user->update([
            'password' => Hash::make($request->input('new_password')),
        ]);

        return redirect()->route('admin.profile', $user->id)->with('success_update_profile_password', 'Пароль успешно изменен.');
    }

    //* Deleting an authorized user
    public function deleteProfile()
    {
        $user = auth()->user();  //* Getting the current authorized user
        $user->delete();

        return redirect()->route('users')->with('success', 'Пользователь успешно удален');
    }
}
