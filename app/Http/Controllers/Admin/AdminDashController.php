<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminDashController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard')->with('title', 'Dashboard');
    }
}
