<?php

namespace Database\Seeders;

use App\Enums\RolesUsersEnum;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createSuperAdmin()->assignRole(RolesUsersEnum::SUPER_ADMIN->value);

        foreach (RolesUsersEnum::asSelectArray() as $role) {
            if ($role['value'] != RolesUsersEnum::SUPER_ADMIN->value) {
                $createUser = $this->createUser();
                $createUser->assignRole($role['value']);
            }
        }

        for ($i = 0; $i < 7; $i++) {
            $this->createUser();
        }

    }

    private function createUser()
    {
        return User::create([
            'name' => fake()->name,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => \Hash::make(fake()->password), // password
            'phone' => fake()->phoneNumber(),
        ]);
    }

    private function createSuperAdmin()
    {
        return User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => \Hash::make('1234567890'), // password
            'phone' => fake()->phoneNumber(),
        ]);
    }
}
