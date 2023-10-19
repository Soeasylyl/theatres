<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Admin\BaseAdminController;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



class LogoutController extends BaseAdminController
{
    /**
     * Выход пользователя из системы.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        if ($response = $this->loggedOut($request)) {
            return $response;
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }

    protected function guard()
    {
        return Auth::guard();
    }

    protected function loggedOut(Request $request)
    {
        //
    }
}
