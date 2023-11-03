<?php

namespace App\Http\Middleware\Users;

use App\Enums\RolesUsersEnum;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use function PHPUnit\Framework\isTrue;

class CheckUserAccessMiddleware
{

    public function __construct(private readonly UserRepositoryInterface   $userRepository)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param \Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requestedUser = $this->userRepository->getUserByIdOrFail($request->route('user'), ['cinemas']);

        /** @var User $currentUser */
        $currentUser = auth()?->user()?->load([
            'cinemas' => function (Builder|BelongsToMany $builder) use ($requestedUser) {
                $builder->whereIn('cinema_id', $requestedUser->cinemas->pluck('id'));
            }
        ]);

        if (
            ! $currentUser ||
            (! $currentUser->hasRole(RolesUsersEnum::SUPER_ADMIN->value) && $currentUser->cinemas->isEmpty())
        ) {
            abort(404);
        }

        return $next($request);
    }
}
