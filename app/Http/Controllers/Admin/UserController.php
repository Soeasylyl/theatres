<?php

namespace App\Http\Controllers\Admin;


use App\Enums\RolesUsersEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends BaseAdminController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $superAdminRole = RolesUsersEnum::SUPER_ADMIN;

        $users = User::with('roles')
            ->where('id', '!=', \Auth::user()->id)
            ->whereDoesntHave('roles', function ($query) use ($superAdminRole) {
                $query->where('name', $superAdminRole);
            })
            ->get();

        $enumRole = RolesUsersEnum::class;

        return view('admin.pages.users.users', compact('users', 'enumRole'));
    }

    public function edit($user)
    {
        $user = User::findOrFail($user);

        $enumRole = RolesUsersEnum::class;
//        dd($enumRole::asSelectArray());
        return view('admin.pages.users.edit', compact('user','enumRole'));
    }

    public function updateInfo(Request $request, $user)
    {
        $user = User::findOrFail($user);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:30',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->save();


        return redirect()->route('user.edit', $user->id)->with('success', 'User information updated successfully.');
    }

    public function updatePassword(Request $request, $user)
    {
        $user = User::findOrFail($user);

        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }
//        dd($user->password);
        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return redirect()->route('user.edit', $user->id)->with('success', 'Password changed successfully.');
    }

    public function delete(User $user)
    {
        $user->delete();
        return redirect()->route('users')->with('success', 'Пользователь успешно удален');
    }

    public function updateRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'nullable|exists:roles,name',
        ]);

        $user = User::findOrFail($request->input('user_id'));
        $roleName = $request->input('role');

        if ($roleName === null) {
            $user->syncRoles([]);
            return redirect()->back()->with('success', 'Все роли пользователя удалены.');
        } else {
            $oldRole = $user->roles->first();

            if ($oldRole) {
                $user->removeRole($oldRole->name);
            }

            $user->assignRole($roleName);

            return redirect()->back()->with('success', 'Роль успешно обновлена.');

        }
    }

//    public function sort($column, $direction)
//    {
//        $allowedColumns = ['name', 'email'];
//        $allowedDirections = ['asc', 'desc'];
//
//        if (!in_array($column, $allowedColumns) || !in_array($direction, $allowedDirections)) {
//            abort(400, 'Invalid sort parameters');
//        }
//
//        $users = User::orderBy($column, $direction)->get();
//        $enumRole = RolesUsersEnum::class;
//
//        return view('admin.pages.users.users', compact('users', 'enumRole'));
//    }
}
