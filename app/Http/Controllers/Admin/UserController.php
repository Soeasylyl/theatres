<?php

namespace App\Http\Controllers\Admin;


use App\DTO\Users\CreateUserDTO;
use App\DTO\Users\DeleteUserDTO;
use App\DTO\Users\EditUserDTO;
use App\DTO\Users\UpdateUserInfoDTO;
use App\DTO\Users\UpdateUserPasswordDTO;
use App\DTO\Users\UpdateUserRoleDTO;
use App\Http\Requests\Admin\Users\UserRequest;
use App\Http\Requests\Admin\Users\UpdatePasswordRequest;
use App\Http\Requests\Admin\Users\UpdateProfileRequest;
use App\Http\Requests\Admin\Users\UpdateRoleRequest;
use App\Services\CinemaService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;


class UserController extends BaseAdminController
{
    public function __construct(
        private readonly UserService   $userService,
        private readonly CinemaService $cinemaService,
    )
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
        $users = $this->userService->getUsersByRole();

        return view('admin.pages.users.main', compact('users'));
    }

    /**
     * Getting all cinemas PaginateList
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function showAddForm()
    {
        $cinemas = $this->cinemaService->getCinemasPaginateList();

        return view('admin.pages.users.add', compact('cinemas'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return RedirectResponse
     */
    protected function create(UserRequest $request)
    {
        $requestDTO = new CreateUserDTO(
            name: $request->input('name'),
            email: $request->input('email'),
            phone: $request->input('phone'),
            password: $request->input('password'),
            cinemaId: $request->input('cinema'),
            roleName: $request->input('role'),
        );

        $this->userService->createUser($requestDTO);

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
        $authUser = auth()->user();

        $editUserDTO = new EditUserDTO(
            authUser: $authUser,
            userId: $userId
        );

        $userData = $this->userService->getUserDataForEdit($editUserDTO);

        return view('admin.pages.users.edit', ['user' => $userData['user'], 'cinemas' => $userData['cinemas'], 'userRole' => $userData['userRole']]);
    }

    /**
     * Updating information for the selected user
     *
     * @param UpdateProfileRequest $request
     * @param int $userId
     * @return RedirectResponse
     */
    public function update(UpdateProfileRequest $request, int $userId)
    {
        $authUser = auth()->user();

        $requestDTO = new UpdateUserInfoDTO(
            authUser: $authUser,
            userId: $userId,
            name: $request->input('name'),
            email: $request->input('email'),
            phone: $request->input('phone'),
        );

        $message = $this->userService->updateInfoByUser($requestDTO);

        return redirect()->route('user.edit', $userId)->with('message', $message);
    }

    /**
     * Updating information for the selected user
     *
     * @param UpdateProfileRequest $request
     * @return RedirectResponse
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $authUser = auth()->user();

        $requestDTO = new UpdateUserInfoDTO(
            authUser: $authUser,
            userId: $request->input('id'),
            name: $request->input('name'),
            email: $request->input('email'),
            phone: $request->input('phone'),
        );

        $message = $this->userService->updateInfoByUser($requestDTO);

        return redirect()->route('user.edit')->with('message', $message);
    }

    /**
     * Updating the password for the selected user
     *
     * @param UpdatePasswordRequest $request
     * @param int $userId
     * @return RedirectResponse
     * @throws \Exception
     */
    public function updatePassword(UpdatePasswordRequest $request, int $userId)
    {
        $authUser = auth()->user();

        $requestDTO = new UpdateUserPasswordDTO(
            authUser: $authUser,
            userId: $userId,
            password: $request->input('new_password'),
            currentPassword: $request->input('current_password'),
        );

        try {
            $this->userService->updatePasswordByUser($requestDTO);

            return redirect()->route('user.edit', $userId)->with('success_update_user_password', 'Пароль успешно изменен.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Updating the password for the selected user
     *
     * @param UpdatePasswordRequest $request
     * @param int $userId
     * @return RedirectResponse
     * @throws \Exception
     */
    public function updatePasswordProfile(UpdatePasswordRequest $request, int $userId)
    {
        $authUser = auth()->user();

        $requestDTO = new UpdateUserPasswordDTO(
            authUser: $authUser,
            userId: $userId,
            password: $request->input('new_password'),
            currentPassword: $request->input('current_password'),
            shouldSkipPermissionCheck: false,
        );

        try {
            $this->userService->updatePasswordByUser($requestDTO);

            return redirect()->route('user.edit', $userId)->with('success_update_user_password', 'Пароль успешно изменен.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Delete a selected user
     *
     * @param int $userId
     * @return RedirectResponse
     */
    public function delete(int $userId)
    {
        $authUser = auth()->user();

        $deleteUserDTO = new DeleteUserDTO(
            authUser: $authUser,
            userId: $userId,
        );

        $message = $this->userService->deleteUser($deleteUserDTO);

        return redirect()->route('users')->with('message', $message);
    }

    /**
     * Change the role of the selected user
     *
     * @param UpdateRoleRequest $request
     * @return RedirectResponse
     */
    public function updateRole(UpdateRoleRequest $request)
    {
        $authUser = auth()->user();

        $requestDTO = new UpdateUserRoleDTO(
            authUser: $authUser,
            userId: $request->input('user_id'),
            role: $request->input('role'),
        );
        try {
            $this->userService->updateUserRole($requestDTO);

            return redirect()->back()->with('success_update_role', 'Роль у пользователя успешно изменена.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
