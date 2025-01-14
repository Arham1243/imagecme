<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseCommentVote extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function caseComment()
    {
        return $this->belongsTo(CaseComment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
