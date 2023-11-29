<?php

namespace App\Http\Controllers\Admin;

use App\Services\TheatreService;
use Illuminate\Contracts\Support\Renderable;

class AdminController extends BaseAdminController
{
    /**
     * Create a new controller instance.
     *
     * @param TheatreService $theatreService
     */
    public function __construct(private readonly TheatreService $theatreService)
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('admin.pages.dashboard');
    }
}
