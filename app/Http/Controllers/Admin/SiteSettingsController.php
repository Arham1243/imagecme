<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Config;
use App\Models\Image;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    use UploadImageTrait;
    
    public function showLogo()
    {
        $logo = Image::where('type', 'logo')->latest()->first();

        return view('admin.site-settings.logo-management')->with('title', 'Logo Management');
    }

    public function saveLogo(Request $request)
    {
        $request->validate([
            'path' => 'required|file|max:2048',
        ]);
        $imageEntry = Image::updateOrCreate(
            ['type' => 'logo']
        );
        $this->uploadImg('path', 'Admin/Logo', $imageEntry, 'path');
        return back()->with('notify_success', 'Logo Updated!');
    }

    public function showContact()
    {
        return view('admin.site-settings.contact-social')->with('title', 'Contact / Social Info Management
        ');
    }

    public function saveContact(Request $request)
    {
        $configs = $request->except('_token');

        foreach ($configs as $key => $value) {
            Config::updateOrCreate(
                ['flag_type' => $key],
                ['flag_value' => $value]
            );
        }
        return redirect()->route('admin.dashboard')->with('notify_success', 'Contact Information Updated!');
    }
}
