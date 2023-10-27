<?php

namespace App\DTO\Users;

class EditUserDTO
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
