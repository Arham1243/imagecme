<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\DiagnosticCase;
use Illuminate\Http\Request;

class DiagnosticCaseController extends Controller
{

    public function index()
    {
        $cases = DiagnosticCase::latest()->get();
        return view('user.cases-management.list')->with('title', 'Cases')->with(compact('cases'));
    }
    public function create() {}
    public function store(Request $request) {}
    public function edit(DiagnosticCase $item)
    {
        return view('user.cases-management.edit')->with('title', ucfirst(strtolower($item->title)))->with(compact('cases'));
    }
    public function update(Request $request, $id) {}
    public function destroy(Request $request, $id) {}
}
