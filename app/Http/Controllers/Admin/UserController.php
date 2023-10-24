<?php

namespace App\Http\Controllers\Admin;


use App\DTO\Users\CreateUserDTO;
use App\DTO\Users\UserUpdateCinemaDTO;
use App\DTO\Users\UserUpdateInfoDTO;
use App\DTO\Users\UserUpdatePasswordDTO;
use App\DTO\Users\UserUpdateRoleDTO;
use App\Http\Requests\Admin\Users\UserRequest;
use App\Http\Requests\Admin\Users\UpdatePasswordRequest;
use App\Http\Requests\Admin\Users\UpdateCinemaRequest;
use App\Http\Requests\Admin\Users\UpdateProfileRequest;
use App\Http\Requests\Admin\Users\UpdateRoleRequest;
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
     * Obtaining information about all users except authorized and super administrator
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index()
    {
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
        $cinemas = $this->cinemaRepository->getAllCinemas();

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
        $user = $this->userRepository->getUserByIdOrFail($userId);
        $userRole = auth()->user()->roles->first();
        $cinemas = $this->cinemaRepository->getAllCinemas();

        return view('admin.pages.users.edit', compact('user', 'cinemas', 'userRole'));
    }

    /**
     * Updating information for the selected user
     *
     * @param UpdateProfileRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateProfileRequest $request, User $user)
    {
        $requestDTO = new UserUpdateInfoDTO(
            name: $request->input('name'),
            email: $request->input('email'),
            phone: $request->input('phone'),
        );

        return $this->userService->updateInfoByUser($requestDTO, $user);
    }

    /**
     * Updating information for the selected user
     *
     * @param UpdateProfileRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(UpdateProfileRequest $request, User $user)
    {
        $requestDTO = new UserUpdateInfoDTO(
            name: $request->input('name'),
            email: $request->input('email'),
            phone: $request->input('phone'),
        );

        return $this->userService->updateInfoByUser($requestDTO, $user);
    }

    /**
     * Updating the password for the selected user
     *
     * @param UpdatePasswordRequest $request
     * @param int $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(UpdatePasswordRequest $request, int $userId)
    {
        $requestDTO = new UserUpdatePasswordDTO(
            password: $request->input('new_password'),
            currentPassword: $request->input('current_password'),
        );

        return $this->userService->updatePasswordByUser($requestDTO, $userId);
    }

    /**
     * Updating the password for the selected user
     *
     * @param UpdatePasswordRequest $request
     * @param int $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePasswordProfile(UpdatePasswordRequest $request, int $userId)
    {
        $requestDTO = new UserUpdatePasswordDTO(
            password: $request->input('new_password'),
            currentPassword: $request->input('current_password'),
        );

        return $this->userService->updatePasswordByUser($requestDTO, $userId);
    }

    /**
     * Delete a selected user
     *
     * @param int $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function delete(int $userId)
    {
        return $this->userService->deleteUser($userId);
    }

    /**
     * Change the role of the selected user
     *
     * @param AdminUpdateUserRoleProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateRole(UpdateRoleRequest $request)
    {
        $requestDTO = new UserUpdateRoleDTO(
            userId: $request->input('user_id'),
            role: $request->input('role'),
        );

        return $this->userService->updateUserRole($requestDTO);
    }

    /**
     * Updating information about the cinema to which the user belongs
     *
     * @param UpdateCinemaRequest $request
     * @return RedirectResponse
     */
    public function updateCinemaAction(UpdateCinemaRequest $request)
    {
        $requestDTO = new UserUpdateCinemaDTO (
            userId: $request->input('user_id'),
            cinema: $request->input('cinema'),
        );

        return $this->userService->updateCinemaUser($requestDTO);
    }
}
