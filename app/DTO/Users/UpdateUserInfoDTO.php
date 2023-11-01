<?php

namespace App\DTO\Users;

use App\Models\User;

class UpdateUserInfoDTO
{
    /**
     * @param User $producer
     * @param string $userId
     * @param string $name
     * @param string $email
     * @param string $phone
     * @param bool $shouldRunPermissionCheck
     */
    public function __construct(
        private readonly User   $producer,
        private readonly string $userId,
        private readonly string $name,
        private readonly string $email,
        private readonly string $phone,
        private readonly bool   $shouldRunPermissionCheck = true,
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}
