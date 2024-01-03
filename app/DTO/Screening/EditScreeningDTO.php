<?php

namespace App\DTO\Screening;

use App\Models\User;

class EditScreeningDTO
{
    /**
     * @param int $screeningId
     */
    public function __construct(
        private readonly int  $screeningId,
    )
    {
    }

    /**
     * @return int
     */
    public function getScreeningId(): int
    {
        return $this->screeningId;
    }
}
