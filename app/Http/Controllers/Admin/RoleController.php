<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class RoleController extends BaseAdminController
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.pages.roles');
    }
}
