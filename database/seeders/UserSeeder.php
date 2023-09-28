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
        $this->createUser(Role::findByName(RolesUsersEnum::SUPER_ADMIN->value));
        $this->createUser(Role::findByName(RolesUsersEnum::CINEMA_ADMIN->value));
        $this->createUser(Role::findByName(RolesUsersEnum::CINEMA_MANAGER->value));
        for ($i = 0; $i < 4; $i++) {
            $this->createUser(Role::findByName(RolesUsersEnum::USER->value));
        }

    }

    private function createUser($role)
    {
        User::create([
            'name' => fake()->name,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'phone' => fake()->phoneNumber(),
            'remember_token' => Str::random(10),
        ])->assignRole($role);
    }
}
