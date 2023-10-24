<?php

namespace Database\Seeders;

use App\Enums\RolesUsersEnum;
use App\Models\Cinema;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createSuperAdmin()->assignRole(RolesUsersEnum::SUPER_ADMIN->value);

        $cinemas = Cinema::all();
        foreach ($cinemas as $cinema) {
            foreach (RolesUsersEnum::asSelectArray() as $role) {
                if ($role['value'] != RolesUsersEnum::SUPER_ADMIN->value) {
                    $createUser = $this->createUser();
                    $createUser->assignRole($role['value']);
                    $cinema->users()->attach($createUser);
                }
            }
        }

        for ($i = 0; $i < 20; $i++) {
            $user = $this->createUser();
            $cinemaCount = rand(0, 2);
            for ($j = 0; $j < $cinemaCount; $j++) {
                $randomCinema = $cinemas->random();
                $randomCinema->users()->attach($user);
            }
        }
    }

    private function createUser()
    {
        return User::create([
            'name' => fake()->name,
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => fake()->password, // password
            'phone' => fake()->phoneNumber(),
        ]);
    }

    private function createSuperAdmin()
    {
        return User::create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => '1234567890', // password
            'phone' => fake()->phoneNumber(),
        ]);
    }
}
