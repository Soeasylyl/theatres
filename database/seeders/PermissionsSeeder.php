<?php

namespace Database\Seeders;

use App\Enums\PermissionsUsersEnum;
use App\Enums\RolesUsersEnum;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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

        Role::create(['name' => RolesUsersEnum::SUPER_ADMIN->value]);

        foreach (PermissionsUsersEnum::asSelectArray() as $permission) {
            Permission::create(['name' => $permission['value']]);
        }

        $cinemaManager = Role::create(['name' => RolesUsersEnum::CINEMA_MANAGER->value]);
        foreach ($this->getCinemaManagerPermissions() as $permission) {
            $cinemaManager->givePermissionTo($permission->value);
        }

        $cinemaAdmin = Role::create(['name' => RolesUsersEnum::CINEMA_ADMIN->value]);
        foreach ($this->getCinemaAdminPermissions() as $permission) {
            $cinemaAdmin->givePermissionTo($permission->value);
        }
    }

    private function getCinemaAdminPermissions(): array
    {
        return [
            PermissionsUsersEnum::MANAGE_CINEMA,
            PermissionsUsersEnum::MANAGE_HALLS,
            PermissionsUsersEnum::MANAGE_SESSIONS,
            PermissionsUsersEnum::MANAGE_SEATS,
            PermissionsUsersEnum::MANAGE_PRICES,
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
