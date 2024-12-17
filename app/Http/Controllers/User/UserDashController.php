<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

class UserDashController extends Controller
{
    public function dashboard()
    {
        return view('user.dashboard')->with('title', 'Dashboard');
    }
}
