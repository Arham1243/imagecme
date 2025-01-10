<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseLike extends Model
{
    protected $fillable = ['case_id', 'user_id'];

    public function case()
    {
        return $this->belongsTo(DiagnosticCase::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
