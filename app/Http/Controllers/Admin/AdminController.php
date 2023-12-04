<?php

namespace App\Http\Controllers\Admin;

use App\Services\CinemaService;
use Illuminate\Contracts\Support\Renderable;

class AdminController extends BaseAdminController
{
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
