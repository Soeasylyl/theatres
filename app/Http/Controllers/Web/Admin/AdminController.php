<?php

namespace App\Http\Controllers\Web\Admin;

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
