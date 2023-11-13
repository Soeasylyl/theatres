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
     * @param string|null $timeZone
     */
    public function __construct(
        private readonly User    $producer,
        private readonly int     $userId,
        private readonly string  $expirationDate,
        private readonly ?string $timeZone = 'UTC',
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

    /**
     * @return Carbon
     */
    public function getExpirationDate(): Carbon
    {
        return Carbon::parse($this->expirationDate)
            ->shiftTimezone($this->timeZone)
            ->setTimezone(now()->timezone->getName());
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}
