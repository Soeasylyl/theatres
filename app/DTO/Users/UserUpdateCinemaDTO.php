<?php

namespace App\DTO\Users;

class UserUpdateCinemaDTO
{
    public function __construct(
        private readonly int     $userId,
        private readonly ?string $cinema,
    )
    {
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function getCinema(): ?string
    {
        return $this->cinema;
    }
}
