<?php

namespace App\DTO\Users;

class UserUpdateInfoDTO
{
    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $phone,
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPhone(): string
    {
        return $this->phone;
    }
}
