<?php

namespace Database\Seeders;

use App\DTO\Users\CreateUserDTO;
use App\Enums\RolesUsersEnum;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * @param UserRepository $userRepository
     */
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->createSuperAdmin()->assignRole(RolesUsersEnum::SUPER_ADMIN->value);
    }

    /**
     * Create a new super admin user using the user repository and the provided data transfer object.
     *
     * @return User
     */
    private function createSuperAdmin(): User
    {
        return $this->userRepository->createUser(new CreateUserDTO(
            name: 'admin',
            email: 'admin@example.com',
            phone: fake()->phoneNumber(),
            password: '1234567890',
        ));
    }
}
