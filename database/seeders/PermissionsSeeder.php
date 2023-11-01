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
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        foreach (PermissionsUsersEnum::asSelectArray() as $permission) {
            Permission::create(['name' => $permission['value']]);
        }

        foreach (RolesUsersEnum::asSelectArray() as $role) {
            $createdRole = Role::create(['name' => $role['value']]);
            $permissions = $this->getPermissionsForRole($role);
            foreach ($permissions as $permission) {
                $createdRole->givePermissionTo($permission->value);
            }
        }
    }

    private function getPermissionsForRole(array $role): array
    {
        return match ($role['value']) {
            RolesUsersEnum::SUPER_ADMIN->value => $this->getSuperAdminPermissions(),
            RolesUsersEnum::CINEMA_MANAGER->value => $this->getCinemaManagerPermissions(),
            RolesUsersEnum::CINEMA_ADMIN->value => $this->getCinemaAdminPermissions(),
            default => [],
        };
    }

    private function getSuperAdminPermissions(): array
    {
        $superAdminPermissions = [];
        foreach (PermissionsUsersEnum::asSelectArray() as $permission) {
            $superAdminPermissions[] = PermissionsUsersEnum::from($permission['value']);
        }

        return $superAdminPermissions;
    }

    private function getCinemaAdminPermissions(): array
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

    private function getCinemaManagerPermissions(): array
    {
        return [
            PermissionsUsersEnum::MANAGE_HALLS,
            PermissionsUsersEnum::MANAGE_SESSIONS,
            PermissionsUsersEnum::VIEW_ADMIN_PANEL,
        ];
    }
}
