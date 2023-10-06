<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RolesUsersEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;


class AdminProfileController extends BaseAdminController
{
    public function profile()
    {
        $user = User::findOrFail(Auth::user()->id);

        $userRole = Auth::user()->roles->first();

//        dd(Auth::user()->roles->first());
        $usersRoles = User::with('roles')->get();
        $enumRole = RolesUsersEnum::class;

        return view('admin.pages.users.profile', compact('user','userRole', 'usersRoles', 'enumRole'));
    }


    public function updateInfo(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:30',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->save();


        return redirect()->route('admin.pages.users.profile', $user->id)->with('success', 'User information updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return redirect()->route('admin.pages.users.profile', $user->id)->with('success', 'Password changed successfully.');
    }

    public function deleteProfile()
    {
        $user = User::findOrFail(Auth::user()->id);
        $user->delete();

        return redirect()->route('users')->with('success', 'Пользователь успешно удален');
    }

}
