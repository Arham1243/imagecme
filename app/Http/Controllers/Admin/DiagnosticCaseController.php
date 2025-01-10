<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DiagnosticCase;
use App\Models\ImageType;
use Illuminate\Http\Request;

class DiagnosticCaseController extends Controller
{
    public function index(Request $request)
    {
        $imageTypes = ImageType::where('status', 'active')->latest()->get();

        $query = DiagnosticCase::query();

        if ($request->has('start_date') && ! empty($request->start_date) && $request->has('end_date') && ! empty($request->end_date)) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
        }

        if ($request->has('diagnosed_disease') && ! empty($request->diagnosed_disease)) {
            $query->where('diagnosed_disease', $request->diagnosed_disease);
        }

        if ($request->has('image_type') && ! empty($request->image_type)) {
            $query->whereHas('images', function ($query) use ($request) {
                $query->where('type', $request->image_type);
            });
        }

        if ($request->has('image_quality') && ! empty($request->image_quality)) {
            $query->where('image_quality', $request->image_quality);
        }

        if ($request->has('ease_of_diagnosis') && ! empty($request->ease_of_diagnosis)) {
            $query->where('ease_of_diagnosis', $request->ease_of_diagnosis);
        }

        if ($request->has('certainty') && ! empty($request->certainty)) {
            $query->where('certainty', $request->certainty);
        }

        if ($request->has('ethnicity') && ! empty($request->ethnicity)) {
            $query->where('ethnicity', $request->ethnicity);
        }

        if ($request->has('segment') && ! empty($request->segment)) {
            $query->where('segment', $request->segment);
        }

        if ($request->has('author_country') && ! empty($request->author_country)) {
            $query->whereHas('user', function ($subQuery) use ($request) {
                $subQuery->where('country', $request->author_country);
            });
        }

        if ($request->has('author_speciality') && ! empty($request->author_speciality)) {
            $query->whereHas('user', function ($subQuery) use ($request) {
                $subQuery->where('speciality', $request->author_speciality);
            });
        }

        $cases = $query->latest()->get();

        return view('admin.cases-management.list')->with('title', 'Images')->with(compact('cases', 'imageTypes'));
    }
}
