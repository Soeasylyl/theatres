<?php

namespace App\DTO\Users;

use App\Models\User;

class UpdateUserRoleDTO
{
    public function __construct(
        private readonly User    $authUser,
        private readonly int     $userId,
        private readonly ?string $role,
        private readonly bool    $shouldSkipPermissionCheck = true,
    )
    {
    }

    public function isShouldSkipPermissionCheck(): bool
    {
        return $this->shouldSkipPermissionCheck;
    }

    public function getAuthUser(): User
    {
        return $this->authUser;
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
