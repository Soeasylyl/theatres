<?php

namespace App\Http\Middleware\Theatres;

use App\Enums\RolesUsersEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckTheatreAccessMiddleware
{
    public function __construct()
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param \Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentUser = auth()?->user();

        if (
            ! $currentUser ||
            ! $currentUser->hasRole(RolesUsersEnum::SUPER_ADMIN->value) &&
            (
                ! $currentUser->hasRole(RolesUsersEnum::CINEMA_ADMIN->value) ||
                (
                    $currentUser->hasRole(RolesUsersEnum::CINEMA_ADMIN->value) &&
                    ! $currentUser->theatres->contains('id', $request->route('theatres'))
                )
            )
        ) {

            abort(404);
        }

        return $next($request);
    }
}
