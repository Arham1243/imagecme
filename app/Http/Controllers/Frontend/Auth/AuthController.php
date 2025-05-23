<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function signup()
    {
        return view('frontend.auth.signup')->with('title', 'Sign Up');
    }

    public function login()
    {
        return view('frontend.auth.login')->with('title', 'Login');
    }

    public function performSignup(Request $request)
    {
        $redirectTo = $request->input('redirect_url');

        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users|max:255',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'password' => 'required|string|min:8',
            'role' => 'required|string',
            'speciality' => 'required|string',
            'institution_name' => 'nullable|string|max:255',
            'country' => 'required|string',
            'city' => 'required|string|max:255',
        ]);

        $user = User::create([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'email' => $validatedData['email'],
            'phone' => $validatedData['phone'],
            'password' => bcrypt($validatedData['password']),
            'role' => $validatedData['role'],
            'speciality' => $validatedData['speciality'],
            'institution_name' => $validatedData['institution_name'],
            'country' => $validatedData['country'],
            'city' => $validatedData['city'],
        ]);

        Auth::login($user);
        if ($redirectTo) {
            return redirect()->to($redirectTo)->with('notify_success', 'Account Created Successfully');
        }

        return redirect()->route('user.dashboard')->with('notify_success', 'Account Created Successfully');
    }

    public function performLogin(Request $request)
    {
        $redirectTo = $request->input('redirect_url');

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            if ($user->status === 'inactive') {
                Auth::logout();

                return redirect()->route('auth.login')
                    ->withErrors(['email' => 'Your account is suspended. Please contact the admin.'])
                    ->with('notify_error', 'Your account is suspended. Please contact the admin.');
            }

            if ($redirectTo) {
                return redirect()->to($redirectTo)->with('notify_success', 'Login Successfully');
            }

            return redirect()->intended(route('user.dashboard'))
                ->with('notify_success', 'Login Successfully');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput()->with('notify_error', 'Invalid credentials');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect()->route('frontend.index')->with('notify_success', 'Logged Out!');
    }
}
