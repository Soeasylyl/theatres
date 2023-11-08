<?php

namespace App\DTO\Users;

use App\Models\User;
use Carbon\Carbon;

class BlockUserDTO
{
    /**
     * @param User $producer
     * @param int $userId
     * @param string $expirationDate
     */
    public function __construct(
        private readonly User   $producer,
        private readonly int    $userId,
        private readonly string $expirationDate,
    )
    {
    }

    public function getProducer(): User
    {
        return $this->producer;
    }

    /**
     * @return Carbon
     */
    public function getExpirationDate(): Carbon
    {
        return Carbon::parse($this->expirationDate);
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}
