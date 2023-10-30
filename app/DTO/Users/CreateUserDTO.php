<?php

namespace App\DTO\Users;

class CreateUserDTO
{
    public function __construct(
        private readonly string  $name,
        private readonly string  $email,
        private readonly string  $phone,
        private readonly string  $password,
        private readonly ?int    $cinemaId = null,
        private readonly ?string $roleName = null,
    )
    {
    }

    public function getRoleName(): ?string
    {
        return $this->roleName;
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
}
