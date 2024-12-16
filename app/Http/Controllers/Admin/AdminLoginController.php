<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Auth;
use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $logo = Image::where('type', 'logo')->latest()->first();
        View()->share('logo', $logo);
    }

    //------------------------- Authentication -------------------------
    public function login()
    {
        $adminGuard = Auth::guard('admin');

        if ($adminGuard->check()) {
            return redirect()->route('admin.dashboard')->with('notify_success', 'You are already logged in as Admin');
        }

        return view('admin.login', ['title' => 'Admin Login']);
    }

    public function performLogin(Request $request)
    {
        // Validate the request input
        $validated = $request->validate([
            'email' => 'nullable|email',
            'password' => 'nullable',
        ]);

        // Attempt to authenticate the user
        if (Auth::guard('admin')->attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ])) {
            // Authentication passed
            return redirect()->intended('admin/dashboard')->with('notify_success', 'You are logged in as Admin');
        } else {
            // Authentication failed
            return redirect()->back()->withInput($request->input())->with('notify_error', 'Invalid Credentials');
        }
    }

    public function logout()
    {
        Auth::guard('admin')->logout();

        return redirect()->route('admin.login')->with('notify_success', 'Logged Out!');
    }
    //------------------------- Authentication -------------------------

}
