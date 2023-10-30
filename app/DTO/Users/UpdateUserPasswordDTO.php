<?php

namespace App\DTO\Users;

use App\Models\User;
use phpDocumentor\Reflection\Types\Boolean;

class UpdateUserPasswordDTO
{
    public function __construct(
        private readonly User    $authUser,
        private readonly int     $userId,
        private readonly ?string $password,
        private readonly ?string $currentPassword,
        private readonly bool    $shouldSkipPermissionCheck = true,
    )
    {
    }

    /**
     * @return bool
     */
    public function getShouldSkipPermissionCheck(): bool
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

    public function getCurrentPassword(): ?string
    {
        return $this->currentPassword;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
}
