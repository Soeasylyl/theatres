<?php

namespace App\DTO\Users;

use App\Models\User;
use Carbon\Carbon;

class BanUserDTO
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
     * Get the expiration date adjusted for the specified timezone.
     *
     * This method parses the expiration date from its original format, shifts its timezone
     * to the specified timezone, and then sets the timezone to the current application timezone.
     * The resulting Carbon instance represents the expiration date in the application's timezone.
     *
     * @return Carbon
     */
    public function getExpirationDate(): Carbon
    {
        return Carbon::parse(time: $this->expirationDate)
            ->shiftTimezone(value: $this->timeZone)
            ->setTimezone(value: now()->timezone->getName());
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }
}
