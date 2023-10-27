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

        $cinemas = Cinema::all();
        $countCinemas = Cinema::count();
        $totalCountSeats = 0;
        foreach ($cinemas as $cinema) {
            $countSeats = Hall::where('cinema_id', $cinema->id)
                ->with('seats')->get()->
                sum(function (Hall $hall) {
                   return $hall->seats->count();
                });
            $totalCountSeats += $countSeats;
        }





        return view('admin.pages.dashboard',
            compact('countUsers'),
            compact('countCinemas','cinemas'),
        );
    }
}
