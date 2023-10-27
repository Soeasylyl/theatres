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
use App\Http\Requests\Admin\Users\UpdateCinemaRequest;
use App\Http\Requests\Admin\Users\UpdateProfileRequest;
use App\Http\Requests\Admin\Users\UpdateRoleRequest;
use App\Models\Role;
use App\Models\User;
use App\Repositories\Interfaces\CinemaRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;


class UserController extends BaseAdminController
{
    public function __construct(
        private readonly UserRepositoryInterface   $userRepository,
        private readonly CinemaRepositoryInterface $cinemaRepository,
        private readonly UserService               $userService
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
        dd(Role::findOrFail(1)->name);
        $users = $this->userService->getUsersByRole();

        return view('admin.pages.users.main', compact('users'));
    }

    /**
     * Getting all cinemas
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function showAddForm()
    {
        $cinemas = $this->cinemaRepository->getCinemasPaginateList();

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
            role: $request->input('role'),
        );

        return $this->userService->createUser($requestDTO);
    }

    /**
     * Retrieving information to display on the selected user's page
     *
     * @param int $userId
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function edit(int $userId)
    {
        $editUserDTO = new EditUserDTO(
          userId: $userId
        );

        $user = $this->userRepository->getUserByIdOrFail($editUserDTO->getUserId());
        $userRole = auth()->user()->roles->first();
        $cinemas = $this->cinemaRepository->getCinemasPaginateList();

        return view('admin.pages.users.edit', compact('user', 'cinemas', 'userRole'));
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
        $requestDTO = new UpdateUserInfoDTO(
            userId: $userId,
            name: $request->input('name'),
            email: $request->input('email'),
            phone: $request->input('phone'),
        );

        return $this->userService->updateInfoByUser($requestDTO);
    }

    /**
     * Updating information for the selected user
     *
     * @param UpdateProfileRequest $request
     * @return RedirectResponse
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $requestDTO = new UpdateUserInfoDTO(
            userId: $request->input('id'),
            name: $request->input('name'),
            email: $request->input('email'),
            phone: $request->input('phone'),
        );

        return $this->userService->updateInfoByUser($requestDTO);
    }

    /**
     * Updating the password for the selected user
     *
     * @param UpdatePasswordRequest $request
     * @param int $userId
     * @return RedirectResponse
     */
    public function updatePassword(UpdatePasswordRequest $request, int $userId)
    {
        $requestDTO = new UpdateUserPasswordDTO(
            userId: $userId,
            password: $request->input('new_password'),
            currentPassword: $request->input('current_password'),
        );

        return $this->userService->updatePasswordByUser($requestDTO);
    }

    /**
     * Updating the password for the selected user
     *
     * @param UpdatePasswordRequest $request
     * @param int $userId
     * @return RedirectResponse
     */
    public function updatePasswordProfile(UpdatePasswordRequest $request, int $userId)
    {
        $requestDTO = new UpdateUserPasswordDTO(
            userId: $userId,
            password: $request->input('new_password'),
            currentPassword: $request->input('current_password'),
        );

        return $this->userService->updatePasswordByUser($requestDTO);
    }

    /**
     * Delete a selected user
     *
     * @param int $userId
     * @return RedirectResponse
     */
    public function delete(int $userId)
    {
        $deleteUserDTO = new DeleteUserDTO(
            userId: $userId,
        );

        return $this->userService->deleteUser($deleteUserDTO);
    }

    /**
     * Change the role of the selected user
     *
     * @param UpdateRoleRequest $request
     * @return RedirectResponse
     */
    public function updateRole(UpdateRoleRequest $request)
    {
        $requestDTO = new UpdateUserRoleDTO(
            userId: $request->input('user_id'),
            role: $request->input('role'),
        );

        return $this->userService->updateUserRole($requestDTO);
    }
}
