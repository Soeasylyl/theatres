<?php

namespace App\DTO\Users;

use App\Models\User;

class GetUserDTO
{
    /**
     * @param User $producer
     */
    public function __construct(
        private readonly User $producer,
    )
    {
    }

    /**
     * @return User
     */
    public function getProducer(): User
    {
        return $this->producer;
    }
}
