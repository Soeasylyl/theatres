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

        // create permissions
        Permission::create(['name' => PermissionsUsersEnum::MANAGE_CINEMA]);
        Permission::create(['name' => PermissionsUsersEnum::MANAGE_HALLS]);
        Permission::create(['name' => PermissionsUsersEnum::MANAGE_SESSIONS]);
        Permission::create(['name' => PermissionsUsersEnum::MANAGE_PRICES]);
        Permission::create(['name' => PermissionsUsersEnum::MANAGE_SEATS]);
        Permission::create(['name' => PermissionsUsersEnum::VIEW_ADMIN_PANEL]);
        Permission::create(['name' => PermissionsUsersEnum::BOOK_SEATS]);

        // create roles and assign existing permissions
        $role1 = Role::create(['name' => RolesUsersEnum::USER->value]);
        $role1->givePermissionTo(PermissionsUsersEnum::BOOK_SEATS->value);

        $role2 = Role::create(['name' => RolesUsersEnum::CINEMA_MANAGER->value]);
        $role2->givePermissionTo(PermissionsUsersEnum::MANAGE_HALLS->value);
        $role2->givePermissionTo(PermissionsUsersEnum::MANAGE_SESSIONS->value);
        $role2->givePermissionTo(PermissionsUsersEnum::VIEW_ADMIN_PANEL->value);

        $role3 = Role::create(['name' => RolesUsersEnum::CINEMA_ADMIN->value]);
        $role3->givePermissionTo(PermissionsUsersEnum::MANAGE_CINEMA->value);
        $role3->givePermissionTo(PermissionsUsersEnum::MANAGE_HALLS->value);
        $role3->givePermissionTo(PermissionsUsersEnum::MANAGE_SESSIONS->value);
        $role3->givePermissionTo(PermissionsUsersEnum::MANAGE_SEATS->value);
        $role3->givePermissionTo(PermissionsUsersEnum::MANAGE_PRICES->value);
        $role3->givePermissionTo(PermissionsUsersEnum::VIEW_ADMIN_PANEL->value);

        $role4 = Role::create(['name' => RolesUsersEnum::SUPER_ADMIN->value]);
    }
}
