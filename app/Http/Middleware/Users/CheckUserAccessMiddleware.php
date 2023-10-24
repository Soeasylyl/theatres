<?php

namespace App\Http\Middleware\Users;

use App\Enums\RolesUsersEnum;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserAccessMiddleware
{

    public function __construct(private readonly UserRepositoryInterface   $userRepository)
    {
    }
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentUser = auth()->user();
        $requestedUser = User::find($request->route('user'));

        if (!$requestedUser) {
            abort(404);
        }

        $currentUserCinemas = $currentUser->cinemas->pluck('id')->toArray();
        $requestedUserCinemas = $requestedUser->cinemas->pluck('id')->toArray();

        if (empty($currentUserCinemas) || empty($requestedUserCinemas)) {
            abort(404);
        }

        $commonCinemas = $this->userRepository->checkUserCinemas($currentUser->id, $requestedUserCinemas);

        if ($currentUser->hasRole(RolesUsersEnum::SUPER_ADMIN->value) || $commonCinemas) {
            return $next($request);
        }

        abort(404);
    }
}
