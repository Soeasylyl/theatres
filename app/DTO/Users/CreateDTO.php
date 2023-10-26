<?php

namespace App\DTO\Users;

class CreateDTO
{
    public function __construct(
        private readonly string  $name,
        private readonly string  $email,
        private readonly string  $phone,
        private readonly string  $password,
        private readonly ?int    $cinemaId = null,
        private readonly ?string $role = null,
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
