<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    /**
     * Redirect the user to the social platform authentication page.
     *
     * @param  string  $social
     * @return \Illuminate\Http\Response
     */
    public function index($social, Request $request)
    {
        // Store the intended URL in the session
        $request->session()->put('url.intended', url()->previous());

        return Socialite::driver($social)->stateless()->redirect();
    }

    /**
     * Obtain the user information from the social platform.
     *
     * @param  string  $social
     * @return \Illuminate\Http\Response
     */
    public function callback($social, Request $request)
    {
        try {
            $socialUser = Socialite::driver($social)->stateless()->user();

            // Check if the user already exists by email
            $existingUser = User::where('email', $socialUser->email)->first();

            if ($existingUser) {
                // User already exists, update their social info and login
                $existingUser->update([
                    'social_id' => $socialUser->id,
                    'signup_method' => $social,
                    'social_token' => $socialUser->token,
                    'avatar' => $socialUser->avatar,
                ]);

                Auth::login($existingUser);
                $redirectTo = $request->session()->pull('url.intended', route('index'));

                return redirect()->to($redirectTo)->with('notify_success', 'Login Successful!');
            } else {
                // User does not exist, create a new user
                $user = User::updateOrCreate([
                    'social_id' => $socialUser->id,
                ], [
                    'signup_method' => $social,
                    'full_name' => $socialUser->name,
                    'email' => $socialUser->email ?? $socialUser->nickname.'@'.$social.'.com', // Handle missing email
                    'social_token' => $socialUser->token,
                    'avatar' => $socialUser->avatar,
                ]);

                Auth::login($user);
                $redirectTo = $request->session()->pull('url.intended', route('index'));

                return redirect()->to($redirectTo)->with('notify_success', 'Signup Successful!');
            }
        } catch (Exception $e) {
            return redirect()->route('index')->with('notify_error', 'Failed to login using '.ucfirst($social).': '.$e->getMessage());
        }
    }
}
