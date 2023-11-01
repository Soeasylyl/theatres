<?php

namespace App\DTO\Users;

use App\Models\User;

class UpdateUserInfoDTO
{
    public function __construct(
        private readonly User   $producer,
        private readonly string $userId,
        private readonly string $name,
        private readonly string $email,
        private readonly string $phone,
        private readonly bool   $shouldRunPermissionCheck = true,
    )
    {
    }

    public function isShouldRunPermissionCheck(): bool
    {
        return $this->shouldRunPermissionCheck;
    }

    public function getProducer(): User
    {
        return $this->producer;
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
