<?php

namespace App\DTO\Users;

class CreateUserDTO
{
    /**
     * @param string $name
     * @param string $email
     * @param string $phone
     * @param string $password
     * @param int|null $cinemaId
     * @param string|null $roleName
     */
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

    /**
     * @return string|null
     */
    public function getRoleName(): ?string
    {
        return $this->roleName;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @return int|null
     */
    public function getCinemaId(): ?int
    {
        return $this->cinemaId;
    }
}
