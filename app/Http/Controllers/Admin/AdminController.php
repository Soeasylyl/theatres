<?php

namespace App\Http\Controllers\Admin;

use App\Enums\RolesUsersEnum;
use App\Http\Controllers\Controller;
use App\Models\Cinema;
use App\Models\Hall;
use App\Models\User;

class AdminController extends BaseAdminController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $countUsers = User::whereDoesntHave('roles', function ( $query) {
            $query->where('name', RolesUsersEnum::SUPER_ADMIN->value);
        })->count();

        $cinemas = Cinema::with('halls.seats')->get();
        $countCinemas = $cinemas->count();
        $totalCountSeats = 0;

        foreach ($cinemas as $cinema) {
            $totalCountSeats += $cinema->halls->sum(function ($hall) {
                return $hall->seats->count();
            });
        }

        return view('admin.pages.dashboard',
            compact('countUsers'),
            compact('countCinemas','cinemas'),
        );
    }
}
