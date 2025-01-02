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
        $cases = DiagnosticCase::where('user_id', Auth::user()->id)->latest()->get();

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
            'content' => $request['case_type'] === 'share_image_diagnosis' ? ($request['content'] ?? null) : null,
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
            'mcq_data' => $request['case_type'] === 'challenge_image_diagnosis' ? json_encode($request['mcqs']) : null,
        ]);

        if ($request->has('image_types')) {
            foreach ($request->input('image_types') as $key => $imageTypeData) {
                // Regular input data
                $type = $imageTypeData['type'];
                $names = $imageTypeData['names'] ?? [];
                $files = $request->file("image_types.{$key}.files") ?? [];

                foreach ($files as $index => $file) {
                    $fileName = $names[$index] ?? null;

                    if ($file) {
                        $filePath = $this->simpleUploadImg(
                            $file,
                            'User/'.Auth::user()->id."/Case/{$diagnosticCase->id}/images/"
                        );

                        CaseImage::create([
                            'case_id' => $diagnosticCase->id,
                            'type' => $type,
                            'name' => $fileName,
                            'path' => $filePath,
                        ]);
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
            'content' => $request['case_type'] === 'share_image_diagnosis' ? ($request['content'] ?? null) : null,
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
            'mcq_data' => $request['case_type'] === 'challenge_image_diagnosis' ? json_encode($request['mcqs']) : null,
        ]);

        if ($request->has('image_types')) {
            foreach ($request->input('image_types') as $key => $imageTypeData) {
                // Regular input data
                $type = $imageTypeData['type'];
                $names = $imageTypeData['names'] ?? [];
                $files = $request->file("image_types.{$key}.files") ?? [];

                foreach ($files as $index => $file) {
                    $fileName = $names[$index] ?? null;

                    if ($file) {
                        $filePath = $this->simpleUploadImg(
                            $file,
                            'User/'.Auth::user()->id."/Case/{$diagnosticCase->id}/images/"
                        );

                        CaseImage::create([
                            'case_id' => $diagnosticCase->id,
                            'type' => $type,
                            'name' => $fileName,
                            'path' => $filePath,
                        ]);
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

    public function saveChat(Request $request, $id)
    {
        $diagnosticCase = DiagnosticCase::findOrFail($id);

        $diagnosticCase->update([
            'ai_conversation' => json_encode($request['conversation']),
        ]);

        return response()->json([
            'message' => 'Chat saved successfully.',
        ], 200);
    }

    public function allChats($id)
    {
        $diagnosticCase = DiagnosticCase::findOrFail($id);

        if ($diagnosticCase->ai_conversation) {
            $aiConversation = json_decode($diagnosticCase->ai_conversation, true);
        } else {
            $aiConversation = [];
        }

        return response()->json([
            'data' => $aiConversation,
        ], 200);
    }

    public function publishConversation(Request $request, $id)
    {
        $diagnosticCase = DiagnosticCase::findOrFail($id);

        $validated = $request->validate([
            'publish_conversation' => 'nullable|boolean',
        ]);

        $diagnosticCase->update([
            'publish_ai_conversation' => $validated['publish_conversation'] ?? 0,
        ]);

        return redirect()->back()
            ->with('notify_success', 'Published Conversation successfully.');
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
