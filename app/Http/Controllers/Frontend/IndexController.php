<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Traits\Sluggable;

class IndexController extends Controller
{
    use Sluggable;

    public function __construct()
    {
        $logo = Image::where('type', 'logo')->latest()->first();
        View()->share('config', $this->getConfig());
        View()->share('logo', $logo);
    }

    public function index()
    {
        return view('frontend.index')->with('title', 'Home');
    }
}
