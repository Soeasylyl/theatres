<?php

namespace App\DTO\Users;

use App\Models\User;

class DeleteUserDTO
{
    /**
     * @param User $producer
     * @param int $userId
     */
    public function __construct(
        private readonly User     $producer,
        private readonly int     $userId,
    )
    {
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
}
