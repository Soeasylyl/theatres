<?php

namespace App\DTO\Users;

class UpdatePasswordDTO
{
    public function __construct(
        private readonly ?string $password,
        private readonly ?string $currentPassword,
        private readonly int $userId,
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
