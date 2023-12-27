<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ScreeningRepositoryInterface
{
    public function getSessionsPaginateList(
        ?int $theatreId = null,
        ?string $date = null,
    ): LengthAwarePaginator;

    public function getFilteredSessionsByProducer(
        User $producer,
        ?int $theatreId = null,
        ?string $date = null,
    ): LengthAwarePaginator;
}
