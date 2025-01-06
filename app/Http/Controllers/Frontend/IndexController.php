<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DiagnosticCase;
use App\Models\ImageType;

class IndexController extends Controller
{
    public function index()
    {
        $cases = DiagnosticCase::where('status', 'active')->latest()->get();
        $imageTypes = ImageType::where('status', 'active')->latest()->get();
        $data = compact('cases', 'imageTypes');

        return view('frontend.index')->with('title', 'Home')->with($data);
    }

    public function imageTypeDetail($slug)
    {
        $item = ImageType::where('slug', $slug)->first();
        $cases = DiagnosticCase::where('status', 'active')->latest()->get();

        $data = compact('item', 'cases');

        return view('frontend.image-types.detail')->with('title', ucfirst(strtolower($item->name)))->with($data);
    }
}
