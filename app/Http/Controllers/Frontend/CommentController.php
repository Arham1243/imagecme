<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CaseView;
use App\Models\Comment;
use App\Models\CommentReply;
use App\Models\DiagnosticCase;
use App\Models\UserMcqAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function index($slug)
    {

        $case = DiagnosticCase::where('slug', $slug)->first();

        $this->trackView($case);

        $groupImages = $case
            ->images()
            ->with('imageType')
            ->get()
            ->groupBy(fn ($image) => $image->imageType->name ?? 'Unknown');

        $comments = $case->comments->map(function ($comment) {
            $editAllowedUntil = $comment->created_at->addMinutes(15);
            $comment->canEdit = now()->lessThan($editAllowedUntil);

            return $comment;
        });
        $data = compact('case', 'comments', 'groupImages');

        return view('frontend.cases.comments')->with('title', 'Comments on '.ucfirst(strtolower($case->title)))->with($data);
    }

    private function trackView(DiagnosticCase $case)
    {
        if (Auth::check()) {
            $userId = Auth::check() ? Auth::id() : null;

            $existingView = CaseView::where('case_id', $case->id)
                ->where('user_id', $userId)
                ->exists();

            if (! $existingView) {
                CaseView::create([
                    'case_id' => $case->id,
                    'user_id' => $userId,
                ]);
            }
        }
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

    public function likeCase(Request $request, $slug, $action)
    {
        if (! Auth::check()) {
            return response()->json([
                'status' => 'error',
                'redirect_url' => route('auth.login', ['redirect_url' => $request->input('current_url')]),
                'message' => 'Please login to like.',
            ], 401);
        }

        $case = DiagnosticCase::where('slug', $slug)->first();

        if (! $case) {
            return response()->json([
                'status' => 'error',
                'message' => 'Case not found',
            ], 404);
        }

        $likeExists = $case->likes()->where('user_id', Auth::user()->id)->exists();

        if ($action == 'like' && ! $likeExists) {
            $case->likes()->create([
                'user_id' => Auth::user()->id,
            ]);

            return response()->json([
                'status' => 'success',
                'action' => 'like',
                'message' => 'Case liked successfully',
                'likesCount' => formatBigNumber($case->likes()->count()),
            ]);
        } elseif ($action == 'unlike' && $likeExists) {
            $case->likes()->where('user_id', Auth::user()->id)->delete();

            return response()->json([
                'status' => 'success',
                'action' => 'unlike',
                'message' => 'Case unliked successfully',
                'likesCount' => formatBigNumber($case->likes()->count()),
            ]);
        }
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

    public function storeReply(Request $request, $slug, $id, $parentReplyId = null)
    {

        if (! Auth::check()) {
            return redirect()->route('auth.login', ['redirect_url' => route('frontend.cases.comments.index', $slug)])->with('notify_error', 'Please login to reply.');
        }

        $request->validate([
            'reply_text' => 'required|string|max:1000',
        ]);

        $case = DiagnosticCase::where('slug', $slug)->first();

        $reply = CommentReply::create([
            'case_id' => $case->id,
            'comment_id' => $id,
            'user_id' => Auth::user()->id,
            'reply_text' => $request->reply_text,
            'parent_reply_id' => $parentReplyId,
        ]);

        return back()->with('notify_success', 'Your reply has been posted.');
    }
}
