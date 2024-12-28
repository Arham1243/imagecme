<?php

namespace App\Http\Controllers\Frontend\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Redirect;

class PasswordResetController extends Controller
{
    public function index()
    {
        return view('frontend.auth.passwords.index')->with('title', 'Reset Your Password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $response = Password::sendResetLink($request->only('email'));

        if ($response == Password::RESET_LINK_SENT) {
            return redirect()->route('password.notify', ['email' => $request->email])->with('notify_success', 'Password reset link has been sent to your email.');
        }

        return Redirect::route('password.request')
            ->withErrors(['email' => 'We could not find a user with that email address.']);
    }

    public function notify(Request $request)
    {

        $email = $request->input('email');

        if (! $email) {
            return redirect()->route('password.request');
        }

        $token = DB::table('password_reset_tokens')->where('email', $email)->first();

        if (! $token) {
            return redirect()->route('auth.login')->with('notify_error', 'No password reset token found for this email.');
        }

        return view('frontend.auth.passwords.notify')->with('title', 'Password Reset Link Sent');
    }

    public function showResetForm($token)
    {
        return view('frontend.auth.passwords.reset', ['token' => $token, 'title' => 'Reset Your Password']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed|different:current_password', // Check if the password is different from the current one
            'token' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Password::tokenExists($user, $request->token)) {
            return Redirect::route('password.reset', ['token' => $request->token])
                ->withErrors(['email' => 'Invalid token or user.']);
        }

        if (Hash::check($request->password, $user->password)) {
            return redirect()->back()
                ->withErrors(['password' => 'Your new password must be different from your current password.'])->with('notify_error', 'Your new password must be different from your current password.');
        }

        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );

        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('auth.login')->with('notify_success', 'Password reset successful. You can now log in.');
        }

        return Redirect::route('password.reset', ['token' => $request->token])
            ->withErrors(['email' => 'Failed to reset the password.']);
    }
}
