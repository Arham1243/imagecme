<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseCommentReply extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function case()
    {
        return $this->belongsTo(DiagnosticCase::class);
    }

    public function comment()
    {
        return $this->belongsTo(CaseComment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parentReply()
    {
        return $this->belongsTo(CaseCommentReply::class, 'parent_reply_id');
    }

    public function replies()
    {
        return $this->hasMany(CaseCommentReply::class, 'parent_reply_id');
    }
}
