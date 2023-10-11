<?php

namespace App\Repositories;



use App\Enums\RolesUsersEnum;
use app\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserRepository implements UserRepositoryInterface
{
    //Obtaining information about all users except authorized and super administrator
    public function getAllUsers()
    {
        return User::whereDoesntHave('roles', function (Builder $query) {
            $query->where('name', RolesUsersEnum::SUPER_ADMIN);
        })->whereNot('id', \Auth::user()->id)->get();
    }

    //Searching for a user by ID
    public function getUserById(int $userId)
    {
        return User::findOrFail($userId);
    }

    //Search for a user by request
    public function getUserByRequest($request)
    {
        return User::findOrFail($request->input('user_id'));
    }

    //getting an authorized user
    public function getAuthUser()
    {
        return auth()->user();
    }

    //Getting the role associated with the passed user
    public function getRoleUser(User $user)
    {
        return $user->roles->first();
    }

    //Changing user information
    public function updateInfoByUser($request, User $user)
    {
        return $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
        ]);
    }

    //Changing the user password
    public function updatePasswordByProfile($request, User $user)
    {
        return $user->update([
            'password' => Hash::make($request->input('new_password'))
        ]);
    }

    //Adding the selected role to a user
    public function addRoleByUser(User $user, $roleName)
    {
        return $user->assignRole($roleName);
    }

    //Removing all user roles
    public function deleteAllRoleByUser(User $user)
    {
        return $user->syncRoles([]);
    }

   public function deleteRoleByUser(User $user, $userRole)
   {
       return $user->removeRole($userRole->name);
   }

    //Deleting a user
    public function deleteUser(User $user)
    {
        return $user->delete();
    }
}
