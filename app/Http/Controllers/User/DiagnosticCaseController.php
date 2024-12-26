<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CaseImage;
use App\Models\DiagnosticCase;
use App\Traits\Sluggable;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiagnosticCaseController extends Controller
{
    use Sluggable;
    use UploadImageTrait;

    public function index()
    {
        $cases = DiagnosticCase::latest()->get();

        return view('user.cases-management.list')->with('title', 'Images')->with(compact('cases'));
    }

    public function create()
    {
        return view('user.cases-management.add')->with('title', 'Add Image');
    }

    public function store(Request $request)
    {

        $diagnosticCase = DiagnosticCase::create([
            'slug' => $this->createSlug($request['diagnosis_title'], 'cases'),
            'case_type' => $request['case_type'],
            'user_id' => Auth::user()->id,
            'content' => $request['content'] ?? null,
            'image_quality' => $request['image_quality'],
            'diagnosis_title' => $request['diagnosis_title'],
            'diagnosed_disease' => $request['diagnosed_disease'],
            'ease_of_diagnosis' => $request['ease_of_diagnosis'] ?? null,
            'certainty' => $request['certainty'] ?? null,
            'ethnicity' => $request['ethnicity'] ?? null,
            'segment' => $request['segment'] ?? null,
            'clinical_examination' => $request['clinical_examination'] ?? null,
            'patient_age' => $request['patient_age'] ?? null,
            'patient_gender' => $request['patient_gender'] ?? null,
            'patient_socio_economic' => $request['patient_socio_economic'] ?? null,
            'patient_concomitant' => $request['patient_concomitant'] ?? null,
            'patient_others' => $request['patient_others'] ?? null,
            'status' => $request['status'],
            'authors' => json_encode($request['authors']),
        ]);

        if (isset($request['case_images']) && ! empty($request['case_images'])) {
            foreach ($request['case_images'] as $imageType => $imageData) {
                if (isset($imageData['images'])) {
                    foreach ($imageData['images']['file'] as $index => $imageFile) {
                        $imageName = $imageData['images']['name'][$index] ?? null;

                        if ($imageFile) {
                            $filePath = $this->simpleUploadImg($imageFile, 'User/'.Auth::user()->id."/Case/{$diagnosticCase->id}/images/");

                            CaseImage::create([
                                'case_id' => $diagnosticCase->id,
                                'type' => $imageType,
                                'name' => $imageName,
                                'path' => $filePath,
                            ]);
                        }
                    }
                }
            }
        }

        $routeName = $diagnosticCase->case_type === 'ask_ai_image_diagnosis'
            ? 'user.cases.chat'
            : 'user.cases.index';

        $routeParams = $routeName === 'user.cases.chat'
            ? ['id' => $diagnosticCase->id]
            : [];

        return redirect()->route($routeName, $routeParams)
            ->with('notify_success', 'Case Created successfully.');
    }

    public function edit($id)
    {
        $case = DiagnosticCase::find($id);

        return view('user.cases-management.edit')->with('title', ucfirst(strtolower($case->diagnosis_title)))->with(compact('case'));
    }

    public function update(Request $request, $id)
    {
        $diagnosticCase = DiagnosticCase::findOrFail($id);

        $diagnosticCase->update([
            'slug' => $this->createSlug($request['diagnosis_title'], 'cases', $diagnosticCase->slug),
            'case_type' => $request['case_type'],
            'user_id' => Auth::user()->id,
            'content' => $request['content'] ?? null,
            'image_quality' => $request['image_quality'],
            'diagnosis_title' => $request['diagnosis_title'],
            'diagnosed_disease' => $request['diagnosed_disease'],
            'ease_of_diagnosis' => $request['ease_of_diagnosis'] ?? null,
            'certainty' => $request['certainty'] ?? null,
            'ethnicity' => $request['ethnicity'] ?? null,
            'segment' => $request['segment'] ?? null,
            'clinical_examination' => $request['clinical_examination'] ?? null,
            'patient_age' => $request['patient_age'] ?? null,
            'patient_gender' => $request['patient_gender'] ?? null,
            'patient_socio_economic' => $request['patient_socio_economic'] ?? null,
            'patient_concomitant' => $request['patient_concomitant'] ?? null,
            'patient_others' => $request['patient_others'] ?? null,
            'status' => $request['status'],
            'authors' => json_encode($request['authors']),
        ]);

        if (isset($request['case_images']) && ! empty($request['case_images'])) {
            foreach ($request['case_images'] as $imageType => $imageData) {
                if (isset($imageData['images'])) {
                    foreach ($imageData['images']['file'] as $index => $imageFile) {
                        $imageName = $imageData['images']['name'][$index] ?? null;

                        if ($imageFile) {
                            $filePath = $this->simpleUploadImg($imageFile, 'User/'.Auth::user()->id."/Case/{$diagnosticCase->id}/images/");

                            CaseImage::create([
                                'case_id' => $diagnosticCase->id,
                                'type' => $imageType,
                                'name' => $imageName,
                                'path' => $filePath,
                            ]);
                        }
                    }
                }
            }
        }

        return redirect()->route('user.cases.index')
            ->with('notify_success', 'Case updated successfully.');
    }

    public function chat($id)
    {
        $case = DiagnosticCase::find($id);

        return view('user.cases-management.chat')->with('title', ucfirst(strtolower($case->diagnosis_title)))->with(compact('case'));
    }

    public function deleteImage($id)
    {
        $image = CaseImage::find($id);

        if (! $image) {
            return redirect()->back()
                ->with('notify_error', 'Image not found.');
        }

        $image->delete();

        return redirect()->back()
            ->with('notify_success', 'Image deleted successfully.');
    }
}
