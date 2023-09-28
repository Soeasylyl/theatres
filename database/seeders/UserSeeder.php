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
        foreach (RolesUsersEnum::asSelectArray() as $role) {
            $createUser = $this->createUser();
            $createUser->assignRole($role['value']);
        }

        for ($i = 0; $i < 4; $i++) {
            $this->createUser();
        }

    }

    private function createUser()
    {
        return User::create([
            'name' => fake()->name,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'phone' => fake()->phoneNumber(),
            'remember_token' => Str::random(10),
        ]);
    }
}
