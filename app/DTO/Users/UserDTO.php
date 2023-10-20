<?php

namespace App\DTO\Users;

class UserDTO
{
    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $phone,
        private readonly string $password,
        private readonly ?int   $cinemaId,
        private readonly ?string   $role
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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCinemaId(): ?int
    {
        return $this->cinemaId;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }
}
