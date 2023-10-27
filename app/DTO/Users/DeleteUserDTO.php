<?php

namespace App\DTO\Users;

class DeleteUserDTO
{
    public function __construct(
        private readonly int     $userId,
    )
    {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
