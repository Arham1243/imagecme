<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\DiagnosticCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index($slug)
    {
        $case = DiagnosticCase::where('slug', $slug)->first();
        $data = compact('case');

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

        try {
            $user_id = Auth::user()->id;
            $case->comments()->create([
                'user_id' => $user_id,
                'case_id' => $case->id,
                'comment_text' => $request->comment,
            ]);

            return redirect()->back()->with('notify_success', 'Comment Added Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('notify_error', 'Oops! Something went wrong: '.$e->getMessage());
        }
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

        return redirect()->back()->with('notify_success', 'Comment updated Successfully');
    }

    public function deleteItem($slug, $id)
    {

        $comment = Comment::find($id);

        if (! $comment) {
            return redirect()->back()->with('notify_error', 'Comment not found.');
        }

        $comment->delete();

        return redirect()->back()->with('notify_success', 'Comment Deleted Successfully');
    }
}
