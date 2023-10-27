<?php

namespace App\DTO\Users;

class UpdateUserPasswordDTO
{
    public function __construct(
        private readonly int $userId,
        private readonly ?string $password,
        private readonly ?string $currentPassword,
    )
    {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getCurrentPassword(): ?string
    {
        return $this->currentPassword;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
}
