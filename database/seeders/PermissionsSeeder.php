<?php

namespace Database\Seeders;

use App\Enums\PermissionsUsersEnum;
use App\Enums\RolesUsersEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (PermissionsUsersEnum::asSelectArray() as $permission) {
            Permission::create(['name' => $permission['value']]);
        }

        foreach (RolesUsersEnum::asSelectArray() as $role) {
            $createdRole = Role::create(['name' => $role['value']]);
            foreach (self::getPermissionsForRole($role) as $permission) {
                $createdRole->givePermissionTo(self::getPermissionsForRole($role));
            }
        }
    }

    /**
     * Get permissions based on the provided role.
     *
     * @param array $role The role for which permissions are required.
     * @return array The array of permissions based on the provided role.
     * @throws \Exception
     */
    private static function getPermissionsForRole(array $role): array
    {
        return match ($role['value']) {
            RolesUsersEnum::SUPER_ADMIN->value => self::getSuperAdminPermissions(),
            RolesUsersEnum::CINEMA_MANAGER->value => self::getCinemaManagerPermissions(),
            RolesUsersEnum::CINEMA_ADMIN->value => self::getCinemaAdminPermissions(),
            default => throw new \Exception('Invalid role provided. Cannot retrieve permissions for the specified role.'),
        };
    }

    /**
     *Get permissions for the super admin role.
     *
     * @return array
     */
    private static function getSuperAdminPermissions(): array
    {
        $superAdminPermissions = [];
        foreach (PermissionsUsersEnum::asSelectArray() as $permission) {
            $superAdminPermissions[] = PermissionsUsersEnum::from($permission['value']);
        }

        return $superAdminPermissions;
    }

    /**
     * Get permissions for the cinema admin role.
     *
     * @return array
     */
    private static function getCinemaAdminPermissions(): array
    {
        return [
            PermissionsUsersEnum::MANAGE_CINEMA,
            PermissionsUsersEnum::MANAGE_HALLS,
            PermissionsUsersEnum::MANAGE_SESSIONS,
            PermissionsUsersEnum::MANAGE_SEATS,
            PermissionsUsersEnum::MANAGE_PRICES,
            PermissionsUsersEnum::MANAGE_USERS,
            PermissionsUsersEnum::VIEW_ADMIN_PANEL,
        ];
    }

    /**
     * Get permissions for the cinema manager role.
     *
     * @return array
     */
    private static function getCinemaManagerPermissions(): array
    {
        return [
            PermissionsUsersEnum::MANAGE_HALLS,
            PermissionsUsersEnum::MANAGE_SESSIONS,
            PermissionsUsersEnum::VIEW_ADMIN_PANEL,
        ];
    }
}
