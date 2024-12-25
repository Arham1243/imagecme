<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\DiagnosticCase;

class DiagnosticCaseController extends Controller
{
    public function details()
    {
        $cases = DiagnosticCase::latest()->get();

        return view('frontend.cases.details')->with('title', 'Case Details');
    }

    public function comments()
    {

        return view('frontend.cases.comments')->with('title', 'Comments');
    }
}
