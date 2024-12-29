<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();

        return view('admin.users-management.list')->with('title', 'Users Management')->with(compact('users'));
    }

    public function show($id)
    {
        $user = User::find($id);

        return view('admin.users-management.show')->with('title', ucfirst(strtolower($user->full_name)))->with(compact('user'));
    }
}
