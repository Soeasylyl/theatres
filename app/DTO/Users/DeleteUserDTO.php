<?php

namespace App\DTO\Users;

use App\Models\User;

class DeleteUserDTO
{
    public function __construct(
        private readonly User     $producer,
        private readonly int     $userId,
    )
    {
    }

    public function getProducer(): User
    {
        return $this->producer;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
