<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiagnosticCase;

class DiagnosticCaseController extends Controller
{
    public function index()
    {
        $cases = DiagnosticCase::latest()->get();

        return view('admin.cases-management.list')->with('title', 'Images')->with(compact('cases'));
    }
}
