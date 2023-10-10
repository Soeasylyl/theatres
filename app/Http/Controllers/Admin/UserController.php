<?php

namespace App\Http\Controllers\Admin;


use App\Enums\RolesUsersEnum;
use App\Http\Requests\AdminProfilePasswordRequest;
use App\Http\Requests\UserProfileUpdateInfoRequest;
use App\Http\Requests\UserProfileUpdateRoleRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
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
    // Obtaining information about all users except authorized and super administrator
    public function index()
    {
        $users = User::whereDoesntHave('roles', function (Builder $query) {
            $query->where('name', RolesUsersEnum::SUPER_ADMIN);
        })->whereNot('id', \Auth::user()->id)->get();

        return view('admin.pages.users.main', compact('users'));
    }

    // Retrieving information to display on the selected user's page
    public function edit(int $user)
    {
        $user = User::findOrFail($user);

        return view('admin.pages.users.edit', compact('user'));
    }

    // Updating information for the selected user
    public function updateInfo(UserProfileUpdateInfoRequest $request, User $user)
    {
        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);

        return redirect()->route('user.edit', $user->id)->with('success_update_user_info', 'Информация о пользователе успешно обновлена.');
    }

    // Updating the password for the selected user
    public function updatePassword(AdminProfilePasswordRequest $request, int $userId)
    {
        $user = User::findOrFail($userId);

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->with('error', 'Текущий пароль неверен.');
        }

        $user->update([
            'password' => Hash::make($request->input('new_password'))
        ]);

        return redirect()->route('user.edit', $user->id)->with('success', 'Пароль успешно изменён.');
    }

    // Delete a selected user
    public function delete(int $userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();

        return redirect()->route('users')->with('success', 'Пользователь успешно удален.');
    }

    // Change the role of the selected user
    public function updateRole(UserProfileUpdateRoleRequest $request)
    {
        $user = User::findOrFail($request->input('user_id'));
        $roleName = $request->input('role');

        // Checking that only super-administrator and administrator can change roles
        if (auth()->user()->roles->first()->name == RolesUsersEnum::SUPER_ADMIN->value || auth()->user()->roles->first()->name == RolesUsersEnum::CINEMA_ADMIN->value) {

            if (auth()->user()->roles->first()->name == RolesUsersEnum::CINEMA_ADMIN->value && ($user->roles->isNotEmpty() && $user->roles->first()->name == RolesUsersEnum::CINEMA_ADMIN->value)) {
                return redirect()->back()->with('error_role', 'Администратор не может изменять роль другому администратору.');
            }

            if (auth()->user()->roles->first()->name == RolesUsersEnum::CINEMA_ADMIN->value && $roleName == RolesUsersEnum::CINEMA_ADMIN->value) {
                return redirect()->back()->with('error_role', 'Администратор не может давать роль администратора.');
            }

            if (auth()->user()->roles->first()->name == RolesUsersEnum::CINEMA_MANAGER->value) {
                return redirect()->back()->with('error_role', 'Менеджеры не могут изменять роли.');
            }

            if ($roleName === null) {
                $user->syncRoles([]);
                return redirect()->back()->with('success_update_role', 'Роль у пользователя успешно удалена.');
            } else {
                $oldRole = $user->roles->first();

                if ($oldRole) {
                    $user->removeRole($oldRole->name);
                }

                $user->assignRole($roleName);

                return redirect()->back()->with('success_update_role', 'Роль у пользователя успешно изменена.');
            }
        } else {
            return redirect()->back()->with('error_role', 'Недостатоно прав для изменения ролей.');
        }

    }
}
