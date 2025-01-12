<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CaseImage;
use App\Models\DiagnosticCase;
use App\Models\ImageType;
use App\Traits\Sluggable;
use App\Traits\UploadImageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiagnosticCaseController extends Controller
{
    use Sluggable;
    use UploadImageTrait;

    public function index(Request $request)
    {
        $imageTypes = ImageType::where('status', 'active')->latest()->get();

        $query = DiagnosticCase::where('user_id', Auth::user()->id);

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

        return view('user.cases-management.list')
            ->with('title', 'Images')
            ->with(compact('cases', 'imageTypes'));
    }

    public function create()
    {
        $imageTypes = ImageType::where('status', 'active')->latest()->get();

        return view('user.cases-management.add')->with('title', 'Add Image')->with(compact('imageTypes'));
    }

    public function store(Request $request)
    {
        if ($request['case_type'] !== 'ask_ai_image_diagnosis') {
            $title = $request['title'];
            $diagnosticCase = DiagnosticCase::create([
                'slug' => $this->createSlug($title, 'cases'),
                'case_type' => $request['case_type'],
                'user_id' => Auth::user()->id,
                'content' => $request['case_type'] === 'share_image_diagnosis' ? ($request['content'] ?? null) : null,
                'image_quality' => $request['image_quality'],
                'title' => $title,
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
        } else {
            $title = 'Untitled';
            $diagnosticCase = DiagnosticCase::create([
                'slug' => $this->createSlug($title, 'cases'),
                'case_type' => $request['case_type'],
                'user_id' => Auth::user()->id,
                'status' => 'inactive',
                'title' => $title,
                'diagnosis_title' => $request['diagnosis_title'],
            ]);
        }

        if ($request->has('image_types')) {
            foreach ($request->input('image_types') as $key => $imageTypeData) {
                $type = $imageTypeData['type'];
                $names = $imageTypeData['names'] ?? [];
                $files = $request->file("image_types.{$key}.files") ?? [];

                foreach ($files as $index => $file) {
                    if ($file) {
                        $fileName = $names[$index] ?? null;
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
        $imageTypes = ImageType::where('status', 'active')->latest()->get();
        $case = DiagnosticCase::find($id);

        return view('user.cases-management.edit')->with('title', ucfirst(strtolower($case->title)))->with(compact('case', 'imageTypes'));
    }

    public function update(Request $request, $id)
    {
        $diagnosticCase = DiagnosticCase::findOrFail($id);

        if ($request['case_type'] !== 'ask_ai_image_diagnosis') {
            $title = $request['title'];

            $diagnosticCase->update([
                'slug' => $this->createSlug($title, 'cases', $diagnosticCase->slug),
                'case_type' => $request['case_type'],
                'user_id' => Auth::user()->id,
                'content' => $request['case_type'] === 'share_image_diagnosis' ? ($request['content'] ?? null) : null,
                'image_quality' => $request['image_quality'],
                'title' => $title,
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
        } else {
            $title = 'Untitled';
            $diagnosticCase->update([
                'slug' => $this->createSlug($title, 'cases', $diagnosticCase->slug),
                'case_type' => $request['case_type'],
                'user_id' => Auth::user()->id,
                'status' => 'inactive',
                'title' => $title,
                'diagnosis_title' => $request['diagnosis_title'],
            ]);
        }

        if ($request->has('image_types')) {
            foreach ($request->input('image_types') as $key => $imageTypeData) {
                $type = $imageTypeData['type'];
                $names = $imageTypeData['names'] ?? [];
                $files = $request->file("image_types.{$key}.files") ?? [];

                foreach ($files as $index => $file) {
                    if ($file) {
                        $fileName = $names[$index] ?? null;
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

    public function updateTitle(Request $request, $id)
    {
        $diagnosticCase = DiagnosticCase::findOrFail($id);

        $title = $request['title'];

        $diagnosticCase->update([
            'slug' => $this->createSlug($title, 'cases', $diagnosticCase->slug),
            'case_type' => $request['case_type'],
            'user_id' => Auth::user()->id,
            'title' => $title,
            'title' => $request['title'],
        ]);

        return response()->json([
            'message' => 'Case updated successfully.',
        ], 200);
    }

    public function chat($id)
    {
        $case = DiagnosticCase::find($id);

        return view('user.cases-management.chat')->with('title', ucfirst(strtolower($case->title)))->with(compact('case'));
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
            'status' => 'active',
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
