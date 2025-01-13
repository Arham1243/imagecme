<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DiagnosticCase;

class DiagnosticCaseController extends Controller
{
    public function details($slug)
    {
        $case = DiagnosticCase::where('slug', $slug)->first();
        $data = compact('case');

        return view('frontend.cases.details')->with('title', ucfirst(strtolower($case->title)).' - Case Details')->with($data);
    }
}
