<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\DiagnosticCase;
use App\Models\UserMcqAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index($slug)
    {
        $case = DiagnosticCase::where('slug', $slug)->first();
        $comments = $case->comments->map(function ($comment) {
            $editAllowedUntil = $comment->created_at->addMinutes(15);
            $comment->canEdit = now()->lessThan($editAllowedUntil);

            return $comment;
        });
        $data = compact('case', 'comments');

        return view('frontend.cases.comments')->with('title', 'Comments on '.ucfirst(strtolower($case->diagnosis_title)))->with($data);
    }

    public function store(Request $request, $slug)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $case = DiagnosticCase::where('slug', $slug)->first();

        if (! $case) {
            return redirect()->back()->with('notify_error', 'Case not found.');
        }

        $user_id = Auth::user()->id;
        $case->comments()->create([
            'user_id' => $user_id,
            'case_id' => $case->id,
            'comment_text' => $request->comment,
            'selected_answer' => $request->selected_answer ?? null,

        ]);

        return redirect(url()->previous().'#comments-section')
            ->with('notify_success', 'Comment Added Successfully');
    }

    public function update(Request $request, $slug, $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $comment = Comment::find($id);

        if (! $comment) {
            return redirect()->back()->with('notify_error', 'Comment not found.');
        }
        if ($comment->user_id !== Auth::id()) {
            return redirect()->back()->with('notify_error', 'Unauthorized action.');
        }

        $comment->update([
            'comment_text' => $request->comment,
            'edited_at' => now(),
        ]);

        return redirect(url()->previous().'#comments-section')
            ->with('notify_success', 'Comment updated Successfully');
    }

    public function submitAnswer(Request $request, $slug)
    {
        $request->validate([
            'answer' => 'required|string',
        ]);

        $case = DiagnosticCase::where('slug', $slug)->first();
        UserMcqAnswer::updateOrCreate([
            'case_id' => $case->id,
            'user_id' => Auth::user()->id,
        ], [
            'answer' => $request->answer,
        ]);

        return redirect(url()->previous().'#comments-section')
            ->with('notify_success', 'Answer submitted Successfully');
    }

    public function deleteItem($slug, $id)
    {

        $comment = Comment::find($id);

        if (! $comment) {
            return redirect()->back()->with('notify_error', 'Comment not found.');
        }

        $comment->delete();

        return redirect(url()->previous().'#comments-section')
            ->with('notify_success', 'Comment Deleted Successfully');
    }
}
