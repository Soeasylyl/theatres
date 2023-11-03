<?php

namespace Database\Factories;

use App\Enums\RolesUsersEnum;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
                'name' =>  fake()->name,
                'email' => fake()->unique()->safeEmail(),
                'email_verified_at' => now(),
                'password' => fake()->password,
                'phone' => fake()->phoneNumber(),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (User $user) {
            $randomNumber = rand(1, 10);
            if ($randomNumber > 7) {
                $roles = [RolesUsersEnum::CINEMA_ADMIN->value, RolesUsersEnum::CINEMA_MANAGER->value];
                $role = fake()->randomElement($roles);
                $user->assignRole($role);
            }
        });
    }
}
