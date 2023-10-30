<?php

namespace App\DTO\Users;

use App\Models\User;

class UpdateUserInfoDTO
{
    public function __construct(
        private readonly User   $authUser,
        private readonly int    $userId,
        private readonly string $name,
        private readonly string $email,
        private readonly string $phone,
    )
    {
    }

    public function getAuthUser(): User
    {
        return $this->authUser;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
