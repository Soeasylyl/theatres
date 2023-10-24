<?php

namespace App\Http\Middleware\Users;

use App\Enums\RolesUsersEnum;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentUser = auth()->user();
        $requestedUser = User::find($request->route('user')) ?: abort(404);

        if ($this->userBelongsToSameCinema($currentUser, $requestedUser)) {
            return $next($request);
        }

        abort(404);
    }

    private function userBelongsToSameCinema($user, $requestedUser): bool
    {
        $currentUserCinemas = $user->cinemas->pluck('id')->toArray();
        $requestedUserCinemas = $requestedUser->cinemas->pluck('id')->toArray();
        $commonCinemas = array_intersect($currentUserCinemas, $requestedUserCinemas);

        if ($user->hasRole(RolesUsersEnum::SUPER_ADMIN->value) || count($commonCinemas) > 0) {
            return true;
        }

        return false;
    }
}
