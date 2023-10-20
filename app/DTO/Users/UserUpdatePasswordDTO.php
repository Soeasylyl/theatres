<?php

namespace App\DTO\Users;

class UserUpdatePasswordDTO
{
    public function __construct(
        private readonly ?string $password,
        private readonly ?string $currentPassword,
    )
    {
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
