<?php

namespace App\Http\Middleware\Users;

use App\Enums\RolesUsersEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authUser = Auth::user();
        if (!$authUser->hasRole(RolesUsersEnum::toArray())) {
            abort(404);
        }

        return $next($request);
    }
}
