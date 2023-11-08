<?php

namespace App\DTO\Users;

use App\Models\User;

class UpdateUserPasswordDTO
{
    /**
     * @param User $producer
     * @param int $userId
     * @param string|null $password
     * @param string|null $currentPassword
     * @param bool $shouldRunPermissionCheck
     */
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
    public function getCurrentPassword(): ?string
    {
        return $this->currentPassword;
    }

    /**
     * @return string|null
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }
}
