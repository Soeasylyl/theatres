<?php

namespace App\DTO\Users;

class UpdateUserRoleDTO
{
    public function __construct(
        private readonly int     $userId,
        private readonly ?string $role,
    )
    {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }
}
