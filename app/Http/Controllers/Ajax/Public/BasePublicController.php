<?php

namespace App\Http\Controllers\Ajax\Public;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;

class BasePublicController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;
}
