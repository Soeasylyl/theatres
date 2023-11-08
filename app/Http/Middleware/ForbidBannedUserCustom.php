<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForbidBannedUserCustom
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $blockedUntil = auth()->user()->blocked_until;

        if ($blockedUntil !== null) {
            \Session::flush();
            return redirect('login')->withInput()->withErrors([
                'email' => __('Аккаунт заблокирован.'),
            ]);
        }

        return $next($request);
    }
}
