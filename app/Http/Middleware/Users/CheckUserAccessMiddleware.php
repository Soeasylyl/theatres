<?php

namespace App\Http\Middleware\Users;

use App\Enums\RolesUsersEnum;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Closure;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckUserAccessMiddleware
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
    )
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param \Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requestedUser = $this->userRepository->getUserByIdOrFail(
            userId: $request->route('user'),
            relations: ['theatres']
        );

        /** @var User $currentUser */
        $currentUser = auth()?->user()?->load([
            'theatres' => function (Builder|BelongsToMany $builder) use ($requestedUser) {
                $builder->whereIn('theatre_id', $requestedUser->theatres->pluck('id'));
            }
        ]);

        if (
            !$currentUser ||
            (
                $currentUser->isNot($requestedUser) &&
                !$currentUser->hasRole(RolesUsersEnum::SUPER_ADMIN->value) &&
                (
                    !$currentUser->hasRole(RolesUsersEnum::CINEMA_ADMIN->value) ||
                    (
                        $currentUser->hasRole(RolesUsersEnum::CINEMA_ADMIN->value) &&
                        ! $currentUser->theatres->intersect($requestedUser->theatres)->isNotEmpty()
                    )
                )
            )
        ) {
            Log::channel('check_user_access')->warning('Access denied for user ' . ($currentUser ? $currentUser->id : 'Guest') . ' to user ' . $requestedUser->id . ' ip address ' . $request->ip());

            abort(404);
        }

        return $next($request);
    }
}
