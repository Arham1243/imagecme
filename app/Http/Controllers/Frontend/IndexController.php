<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DiagnosticCase;

class IndexController extends Controller
{
    public function index()
    {
        $cases = DiagnosticCase::where('status', 'active')->latest()->get();
        $data = compact('cases');

        return view('frontend.index')->with(['title' => 'Home', 'cases' => $cases]);
    }

    public function imagingDetail($slug)
    {
        $portfolioItems = [
            [
                'slug' => 'x-ray',
                'title' => 'X Ray',
                'image' => 'frontend/assets/images/portfolio/1.png',
            ],
            [
                'slug' => 'ct-scan',
                'title' => 'CT Scan',
                'image' => 'frontend/assets/images/portfolio/2.png',
            ],
            [
                'slug' => 'mri',
                'title' => 'MRI',
                'image' => 'frontend/assets/images/portfolio/3.png',
            ],
            [
                'slug' => 'ultrasound-diagnostic',
                'title' => 'Ultrasound, Diagnostic',
                'image' => 'frontend/assets/images/portfolio/4.png',
            ],
            [
                'slug' => 'mammography',
                'title' => 'Mammography',
                'image' => 'frontend/assets/images/portfolio/5.jpg',
            ],
            [
                'slug' => 'pet-scan',
                'title' => 'PET Scan',
                'image' => 'frontend/assets/images/portfolio/5.png',
            ],
        ];
        $item = collect($portfolioItems)->firstWhere('slug', $slug);

        $data = compact('item');

        return view('frontend.imaging.detail')->with('title', ucfirst(strtolower($item['title'])))->with($data);
    }
}
