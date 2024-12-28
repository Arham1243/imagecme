<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileSettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        return view('user.profile-settings.personal-info')->with('title', 'Personal Information')->with(compact('user'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10',
            'role' => 'required|string',
            'speciality' => 'required|string',
            'institution_name' => 'required|string|max:255',
            'country' => 'required|string',
            'city' => 'required|string|max:255',
        ]);

        User::where('id', Auth::user()->id)->update([
            'first_name' => $validatedData['first_name'],
            'last_name' => $validatedData['last_name'],
            'phone' => $validatedData['phone'],
            'role' => $validatedData['role'],
            'speciality' => $validatedData['speciality'],
            'institution_name' => $validatedData['institution_name'],
            'country' => $validatedData['country'],
            'city' => $validatedData['city'],
        ]);

        return redirect()->back()->with('notify_success', 'Information Updated Successfully');
    }

    public function changePassword()
    {
        $user = Auth::user();

        return view('user.profile-settings.change-password')->with('title', 'Change Password')->with(compact('user'));
    }

    public function updatePassword(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::where('id', Auth::user()->id)->update([
            'password' => bcrypt($validatedData['password']),
        ]);

        return redirect()->back()->with('notify_success', 'Password Updated Successfully');
    }
}
