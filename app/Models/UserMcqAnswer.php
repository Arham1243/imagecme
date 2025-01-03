<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserMcqAnswer extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $table = 'user_mcq_answers';

    public function diagnosticCase()
    {
        return $this->belongsTo(DiagnosticCase::class, 'case_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
