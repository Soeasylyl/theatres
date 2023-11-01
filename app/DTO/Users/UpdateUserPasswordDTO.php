<?php

namespace App\DTO\Users;

use App\Models\User;
use phpDocumentor\Reflection\Types\Boolean;

class UpdateUserPasswordDTO
{
    public function __construct(
        private readonly User    $producer,
        private readonly int     $userId,
        private readonly ?string $password,
        private readonly ?string $currentPassword,
        private readonly bool    $shouldRunPermissionCheck = true,
    )
    {
    }

    /**
     * @return bool
     */
    public function isShouldRunPermissionCheck(): bool
    {
        return $this->shouldRunPermissionCheck;
    }


    public function getProducer(): User
    {
        return $this->producer;
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
