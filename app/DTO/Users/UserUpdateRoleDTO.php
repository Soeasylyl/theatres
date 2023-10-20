<?php

namespace App\DTO\Users;

class UserUpdateRoleDTO
{
    public function __construct(
        private readonly int $user_id,
        private readonly ?string $role,
    )
    {
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }
}
