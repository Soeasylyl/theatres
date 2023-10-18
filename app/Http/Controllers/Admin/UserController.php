<?php

namespace App\Http\Controllers\Admin;


use App\Enums\RolesUsersEnum;
use App\Http\Requests\AdminPasswordRequest;
use App\Http\Requests\AdminProfilePasswordRequest;
use App\Http\Requests\UpdateCinemaRequest;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserProfileUpdateInfoRequest;
use App\Http\Requests\UserProfileUpdateRoleRequest;
use App\Models\Cinema;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
 use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;


class UserController extends BaseAdminController
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    /*
     * Obtaining information about all users except authorized and super administrator
     */
    public function index()
    {
        $users = $this->userRepository->getAllUsers();


        return view('admin.pages.users.main', compact('users' ));
    }

    public function showAddForm()
    {
        $cinemas = Cinema::all();

        return view('admin.pages.users.add', compact('cinemas'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return RedirectResponse
     */
    protected function createUser(UserCreateRequest $request)
    {
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => Hash::make($request->input('password')),
        ]);

        if ($request->has('cinema')) {
            $user->cinemas()->attach($request->input('cinema'));
        }

        if ($request->has('role')) {
            $user->assignRole($request->input('role'));
        }

        return redirect()->route('users')->with('success_create_user', 'Пользователь успешно создан');
    }

    /**
     * Retrieving information to display on the selected user's page
     *
     * @param int $userId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit(int $userId)
    {
        $user = $this->userRepository->getUserByIdOrFail($userId);
        $cinemas = Cinema::all();

        return view('admin.pages.users.edit', compact('user', 'cinemas'));
    }

    /**
     * Updating information for the selected user
     *
     * @param UserProfileUpdateInfoRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateInfo(UserProfileUpdateInfoRequest $request, User $user)
    {
        if (auth()->user()->hasRole(RolesUsersEnum::CINEMA_ADMIN->value) && ($user->hasRole(RolesUsersEnum::CINEMA_ADMIN->value))) {
            return redirect()->back()->with('error', 'Администратор не может редактировать данные другому администратору.');
        }

        if (auth()->user()->hasRole(RolesUsersEnum::CINEMA_MANAGER->value) && ($user->hasRole(RolesUsersEnum::CINEMA_ADMIN->value))) {
            return redirect()->back()->with('error', 'Менеджеры не может может редактировать данные другому администратору.');
        }

        if (auth()->user()->hasRole(RolesUsersEnum::CINEMA_MANAGER->value) && ($user->hasRole(RolesUsersEnum::CINEMA_MANAGER->value))) {
            return redirect()->back()->with('error', 'Менеджеры не может может редактировать данные другому менеджеру.');
        }

        $this->userRepository->updateInfoByUser($request, $user);

        return redirect()->route('user.edit', $user->id)->with('success_update_user_info', 'Информация о пользователе успешно обновлена.');
    }

    /**
     * Updating the password for the selected user
     *
     * @param AdminProfilePasswordRequest $request
     * @param int $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(AdminPasswordRequest $request, int $userId)
    {
        $user = $this->userRepository->getUserByIdOrFail($userId);

        if (auth()->user()->hasRole(RolesUsersEnum::CINEMA_ADMIN->value) && ($user->hasRole(RolesUsersEnum::CINEMA_ADMIN->value))) {
            return redirect()->back()->with('error', 'Администратор не может изменить пароль другому администратору.');
        }

        if (auth()->user()->hasRole(RolesUsersEnum::CINEMA_MANAGER->value) && ($user->hasRole(RolesUsersEnum::CINEMA_ADMIN->value))) {
            return redirect()->back()->with('error', 'Менеджеры не может изменить пароль другому администратору.');
        }

        if (auth()->user()->hasRole(RolesUsersEnum::CINEMA_MANAGER->value) && ($user->hasRole(RolesUsersEnum::CINEMA_MANAGER->value))) {
            return redirect()->back()->with('error', 'Менеджеры не может изменить пароль другому менеджеру.');
        }

        if ($request->input('current_password') && !Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->with('error', 'Текущий пароль неверен.');
        }

        $this->userRepository->updatePasswordByProfile($request, $user);

        return redirect()->route('user.edit', $user->id)->with('success_update_user_password', 'Пароль успешно изменён.');
    }

    /**
     * Delete a selected user
     *
     * @param int $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(int $userId)
    {
        $user = $this->userRepository->getUserByIdOrFail($userId);

        if (auth()->user()->hasRole(RolesUsersEnum::CINEMA_ADMIN->value) && ($user->hasRole(RolesUsersEnum::CINEMA_ADMIN->value))) {
            return redirect()->back()->with('error_delete_user', 'Администратор не может удалить другого администратора.');
        }

        if (auth()->user()->hasRole(RolesUsersEnum::CINEMA_MANAGER->value) && ($user->hasRole(RolesUsersEnum::CINEMA_ADMIN->value))) {
            return redirect()->back()->with('error_delete_user', 'Менеджеры не может удалить другого администратора.');
        }

        if (auth()->user()->hasRole(RolesUsersEnum::CINEMA_MANAGER->value) && ($user->hasRole(RolesUsersEnum::CINEMA_MANAGER->value))) {
            return redirect()->back()->with('error_delete_user', 'Менеджеры не может удалить другого менеджера.');
        }

        $user->delete();

        return redirect()->route('users')->with('success_delete_user', 'Пользователь успешно удален.');
    }

    /**
     * Change the role of the selected user
     *
     * @param UserProfileUpdateRoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateRole(UserProfileUpdateRoleRequest $request)
    {
        $user = $this->userRepository->getUserByRequestOrFail($request);
        $roleNameRequest = $request->input('role');

        /**
         * Checking that only super-administrator and administrator can change roles
         */
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
        } else {
            return redirect()->back()->with('error_role', 'Недостатоно прав для изменения ролей.');
        }
    }

    public function updateCinema(UpdateCinemaRequest $request)
    {
        $user = $this->userRepository->getUserByRequestOrFail($request);
        $cinemaIdRequest = $request->input('cinema');

        // Проверка того, что только суперадминистратор и администратор могут изменять кинотеатры
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
