<?php

namespace App\Http\Controllers\Admin;

use App\DTO\Users\BanUserDTO;
use App\DTO\Users\CreateUserDTO;
use App\DTO\Users\DeleteUserDTO;
use App\DTO\Users\EditUserDTO;
use App\DTO\Users\SearchUserDTO;
use App\DTO\Users\UpdateUserInfoDTO;
use App\DTO\Users\UpdateUserPasswordDTO;
use App\DTO\Users\UpdateUserRoleDTO;
use App\Http\Requests\Admin\Users\BlockRequest;
use App\Http\Requests\Admin\Users\SearchRequest;
use App\Http\Requests\Admin\Users\UpdatePasswordRequest;
use App\Http\Requests\Admin\Users\UpdateProfileRequest;
use App\Http\Requests\Admin\Users\UpdateRoleRequest;
use App\Http\Requests\Admin\Users\CreateUserRequest;
use App\Services\TheatreService;
use App\Services\UserService;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends BaseAdminController
{
    /**
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function index(SearchRequest $request, UserService $userService)
    {
        $authUser = auth()->user();
        $searchTern = $request->input('search');

        $searchUserDTO = new searchUserDTO(
            producer: $authUser,
            searchTerm: $searchTern
        );

        $users = $userService->fetchUsersForRole($searchUserDTO);

        return view('admin.pages.users.main', compact('users', 'searchTern'));
    }

    /**
     * Getting all cinemas PaginateList
     *
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function create(TheatreService $theatreService)
    {
        $cinemas = $theatreService->getPaginatedCinemasList();

        return view('admin.pages.users.add', compact('cinemas'));
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @return RedirectResponse
     */
    protected function store(CreateUserRequest $request, UserService $userService)
    {
        $requestDTO = new CreateUserDTO(
            name: $request->input('name'),
            email: $request->input('email'),
            phone: $request->input('phone'),
            password: $request->input('password'),
            cinemaId: $request->input('cinema'),
            roleName: $request->input('role'),
        );

        $userService->createUser($requestDTO);

        return redirect()->route('users')->with('successMessages', 'Пользователь успешно создан');
    }

    /**
     * Retrieving information to display on the selected user's page
     *
     * @param int $userId
     * @param UserService $userService
     * @return Application|Factory|View|\Illuminate\Foundation\Application
     */
    public function edit(int $userId, UserService $userService)
    {
        $authUser = auth()->user();

        $editUserDTO = new EditUserDTO(
            producer: $authUser,
            userId: $userId
        );

        $userData = $userService->getUserDataForEdit($editUserDTO);

        return view('admin.pages.users.edit', compact('authUser'), [
            'user' => $userData['user'],
            'cinemas' => $userData['cinemas'],
            'userRole' => $userData['userRole'],
            'userCinemasList' => $userData['userCinemasList'],
        ]);
    }

    /**
     * Updating information for the selected user
     *
     * @param UpdateProfileRequest $request
     * @param int $userId
     * @param UserService $userService
     * @return RedirectResponse
     */
    public function update(
        UpdateProfileRequest $request,
        int                  $userId,
        UserService          $userService,
    )
    {
        $authUser = auth()->user();

        $requestDTO = new UpdateUserInfoDTO(
            producer: $authUser,
            userId: $userId,
            name: $request->input('name'),
            email: $request->input('email'),
            phone: $request->input('phone'),
        );

        try {
            $userService->updateInfoByUser($requestDTO);

            return redirect()->route('user.edit', $userId)->with('message', 'Информация успешно обновлена');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Updating information for the selected user
     *
     * @param UpdateProfileRequest $request
     * @param int $userId
     * @param UserService $userService
     * @return RedirectResponse
     */
    public function updateProfile(
        UpdateProfileRequest $request,
        int                  $userId,
        UserService          $userService,
    )
    {
        $authUser = auth()->user();

        $requestDTO = new UpdateUserInfoDTO(
            producer: $authUser,
            userId: $userId,
            name: $request->input('name'),
            email: $request->input('email'),
            phone: $request->input('phone'),
            shouldRunPermissionCheck: false,
        );

        try {
            $userService->updateInfoByUser($requestDTO);

            return redirect()->route('user.edit', $userId)->with('message', 'Информация успешно обновлена');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Updating the password for the selected user
     *
     * @param UpdatePasswordRequest $request
     * @param int $userId
     * @param UserService $userService
     * @return RedirectResponse
     */
    public function updatePassword(
        UpdatePasswordRequest $request,
        int                   $userId,
        UserService           $userService,
    )
    {
        $authUser = auth()->user();

        $requestDTO = new UpdateUserPasswordDTO(
            producer: $authUser,
            userId: $userId,
            password: $request->input('new_password'),
            currentPassword: $request->input('current_password'),
        );

        try {
            $userService->updatePasswordByUser($requestDTO);

            return redirect()
                ->route('user.edit', $userId)
                ->with('success_update_user_password', 'Пароль успешно изменен.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('password_error', $e->getMessage());
        }
    }

    /**
     * Updating the password for the selected user
     *
     * @param UpdatePasswordRequest $request
     * @param int $userId
     * @param UserService $userService
     * @return RedirectResponse
     */
    public function updatePasswordProfile(
        UpdatePasswordRequest $request,
        int                   $userId,
        UserService           $userService,
    )
    {
        $authUser = auth()->user();

        $requestDTO = new UpdateUserPasswordDTO(
            producer: $authUser,
            userId: $userId,
            password: $request->input('new_password'),
            currentPassword: $request->input('current_password'),
            shouldRunPermissionCheck: false,
        );

        try {
            $userService->updatePasswordByUser($requestDTO);

            return redirect()
                ->route('user.edit', $userId)
                ->with('success_update_user_password', 'Пароль успешно изменен.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('password_error', $e->getMessage());
        }
    }

    /**
     * Delete a selected user
     *
     * @param int $userId
     * @param UserService $userService
     * @return RedirectResponse
     */
    public function destroy(int $userId, UserService $userService)
    {
        $authUser = auth()->user();

        $deleteUserDTO = new DeleteUserDTO(
            producer: $authUser,
            userId: $userId,
        );

        try {
            $userService->deleteUser($deleteUserDTO);

            return redirect()->route('users')->with('successMessages', 'Пользователь успешно удален.');
        } catch (\Throwable $e) {
            return redirect()->route('users')->with('error_delete_user', $e->getMessage());
        }
    }

    /**
     * Change the role of the selected user
     *
     * @param UpdateRoleRequest $request
     * @param UserService $userService
     * @return RedirectResponse
     */
    public function updateRole(UpdateRoleRequest $request, UserService $userService)
    {
        $authUser = auth()->user();

        $requestDTO = new UpdateUserRoleDTO(
            producer: $authUser,
            userId: $request->input('user_id'),
            roleName: $request->input('role'),
        );

        try {
            $userService->updateUserRole($requestDTO);

            return redirect()->back()->with('success_update_role', 'Роль у пользователя успешно изменена.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error_role', $e->getMessage());
        }
    }

    /**
     * Method for blocking a user.
     *
     * @param BlockRequest $request
     * @param int $userId
     * @param UserService $userService
     * @return null
     */
    public function block(
        BlockRequest $request,
        int          $userId,
        UserService  $userService
    )
    {
        $authUser = auth()->user();

        $banUserDTO = new BanUserDTO(
            producer: $authUser,
            userId: $userId,
            expirationDate: Carbon::parse($request->input('dateTime')),
            timeZone: $request->input('timeZone'),
        );

        try {
            $userService->blockUser($banUserDTO);

            return redirect()->route('users')->with('successMessages', 'Пользователь успешно заблокирован.');
        } catch (\Throwable $e) {
            return redirect()->route('users')->with('error_delete_user', $e->getMessage());
        }
    }
}
