<?php

namespace App\Http\Controllers\public;

use App\Http\Controllers\Controller;
use App\Models\Media;

class HomeController extends BasePublicController
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('public.pages.home');
    }
}
