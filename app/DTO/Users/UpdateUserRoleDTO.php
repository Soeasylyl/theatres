<?php

namespace App\DTO\Users;

use App\Models\User;

class UpdateUserRoleDTO
{
    /**
     * @param User $producer
     * @param int $userId
     * @param string|null $roleName
     * @param bool $shouldSkipPermissionCheck
     */
    public function __construct(
        private readonly User    $producer,
        private readonly int     $userId,
        private readonly ?string $roleName,
        private readonly bool    $shouldSkipPermissionCheck = true,
    )
    {
    }

    /**
     * @return bool
     */
    public function isShouldSkipPermissionCheck(): bool
    {
        return $this->shouldSkipPermissionCheck;
    }

    /**
     * @return User
     */
    public function getProducer(): User
    {
        return $this->producer;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string|null
     */
    public function getRoleName(): ?string
    {
        return $this->roleName;
    }
}
