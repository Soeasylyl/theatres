<?php

namespace App\DTO\Users;

use App\Models\User;

class UpdateUserRoleDTO
{
    public function __construct(
        private readonly User    $producer,
        private readonly int     $userId,
        private readonly ?string $roleName,
        private readonly bool    $shouldSkipPermissionCheck = true,
    )
    {
    }

    public function isShouldSkipPermissionCheck(): bool
    {
        return $this->shouldSkipPermissionCheck;
    }

    public function getProducer(): User
    {
        return $this->producer;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }

    public function getRoleName(): ?string
    {
        return $this->roleName;
    }
}
