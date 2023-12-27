<?php

namespace App\Repositories;

use App\Models\Screening;
use App\Models\User;
use App\Repositories\Interfaces\ScreeningRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;

class ScreeningRepository implements ScreeningRepositoryInterface
{
    public function getSessionsPaginateList(
        ?int    $theatreId = null,
        ?string $date = null,
    ): LengthAwarePaginator
    {
        return Screening::with(['hall.theatre', 'movie'])
            ->when(!is_null($theatreId), function (Builder $builder) use ($theatreId) {
                $builder->whereHas('hall.theatre', fn (Builder $subBuilder) =>
                    $subBuilder->where('id', $theatreId));
            })
            ->when(!is_null($date), fn (Builder $builder) =>
                $builder->whereDate('start_at', $date))
            ->orderBy('start_at', 'desc')
            ->paginate(config('app.pagination_limit'));
    }

    public function getFilteredSessionsByProducer(
        User    $producer,
        ?int    $theatreId = null,
        ?string $date = null,
    ): LengthAwarePaginator
    {
        return Screening::with(['hall.theatre', 'movie'])
            ->when(!is_null($date), fn (Builder $builder) =>
                $builder->whereDate('start_at', $date))
            ->when(!is_null($theatreId), function (Builder $builder) use ($theatreId) {
                $builder->whereHas('hall.theatre', fn (Builder $builder) =>
                    $builder->where('id', $theatreId));
            })
            ->whereHas('hall.theatre.users', fn (Builder $builder) =>
                $builder->where('user_id', $producer->id))
            ->orderBy('start_at', 'desc')
            ->paginate(config('app.pagination_limit'));
    }
}
