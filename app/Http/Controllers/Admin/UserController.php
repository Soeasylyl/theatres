<?php

namespace App\Http\Controllers\Admin;


use App\DTO\Users\UserDTO;
use App\DTO\Users\UserUpdateCinemaDTO;
use App\DTO\Users\UserUpdateInfoDTO;
use App\DTO\Users\UserUpdatePasswordDTO;
use App\DTO\Users\UserUpdateRoleDTO;

use App\Http\Requests\AdminPasswordRequest;
use App\Http\Requests\AdminUpdateCinemaRequest;
use App\Http\Requests\AdminCreateUserRequest;
use App\Http\Requests\AdminUpdateInfoUserProfileRequest;
use App\Http\Requests\AdminUpdateRoleUserProfileRequest;
use App\Models\User;
use App\Repositories\Interfaces\CinemaRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;


class UserController extends BaseAdminController
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly CinemaRepositoryInterface $cinemaRepository,
        private readonly UserService $userService
    )
    {
        $this->middleware('auth');
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
        $users = $this->userRepository->getAllUsers();

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
     * @param  array  $data
     * @return RedirectResponse
     */
    protected function createUser(AdminCreateUserRequest $request)
    {
        $requestDTO = new UserDTO(
            name: $request->input('name'),
            email: $request->input('email'),
            phone: $request->input('phone'),
            password: $request->input('password'),
            cinemaId: $request->input('cinema'),
            role:  $request->input('role'),
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

        return view('admin.pages.users.edit', compact('user', 'cinemas','userRole'));
    }

    /**
     * Updating information for the selected user
     *
     * @param AdminUpdateInfoUserProfileRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateInfo(AdminUpdateInfoUserProfileRequest $request, User $user)
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
     * @param AdminPasswordRequest $request
     * @param int $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(AdminPasswordRequest $request, int $userId)
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
     * @param AdminUpdateRoleUserProfileRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateRole(AdminUpdateRoleUserProfileRequest $request)
    {
        $requestDTO = new UserUpdateRoleDTO(
            user_id: $request->input('user_id'),
            role: $request->input('role'),
        );

        return $this->userService->updateRoleUser($requestDTO);
    }

    /**
     * Updating information about the cinema to which the user belongs
     *
     * @param AdminUpdateCinemaRequest $request
     * @return RedirectResponse
     */
    public function updateCinema(AdminUpdateCinemaRequest $request)
    {
        $requestDTO = new UserUpdateCinemaDTO (
            userId: $request->input('user_id'),
            cinema: $request->input('cinema'),
        );

        return $this->userService->updateCinemaUser($requestDTO);
    }
}
