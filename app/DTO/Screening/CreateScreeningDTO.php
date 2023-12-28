<?php

namespace App\DTO\Screening;

use App\Models\User;
use Carbon\Carbon;

class CreateScreeningDTO
{
    /**
     * @param User $producer
     */
    public function __construct(
        private readonly User $producer,

    )
    {
    }

}
