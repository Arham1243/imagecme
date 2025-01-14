<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseComment extends Model
{
    protected $table = 'case_comments';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function case()
    {
        return $this->belongsTo(DiagnosticCase::class);
    }

    public function userAnswer()
    {
        return $this->belongsTo(UserMcqAnswer::class, 'selected_answer');
    }

    public function replies()
    {
        return $this->hasMany(CaseCommentReply::class, 'comment_id', 'id');
    }

    public function votes()
    {
        return $this->hasMany(CaseCommentVote::class);
    }

    public function upvotes()
    {
        return $this->hasMany(CaseCommentVote::class)->where('is_upvote', true);
    }

    public function downvotes()
    {
        return $this->hasMany(CaseCommentVote::class)->where('is_upvote', false);
    }
}
