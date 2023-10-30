<?php

namespace App\DTO\Users;

use App\Models\User;

class DeleteUserDTO
{
    public function __construct(
        private readonly User     $authUser,
        private readonly int     $userId,
    )
    {
    }

    public function getAuthUser(): User
    {
        return $this->authUser;
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
