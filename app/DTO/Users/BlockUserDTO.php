<?php

namespace App\DTO\Users;

use Carbon\Carbon;

class BlockUserDTO
{
    /**
     * @param int $userId
     * @param string $date
     */
    public function __construct(
        private readonly int  $userId,
        private readonly string  $date,
    )
    {
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return Carbon
     */
    public function getDate(): Carbon
    {
        return Carbon::parse($this->date);
    }
}
