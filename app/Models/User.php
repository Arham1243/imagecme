<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function comments()
    {
        return $this->hasMany(CaseComment::class);
    }

    public function cases()
    {
        return $this->hasMany(DiagnosticCase::class);
    }

    public function userMcqAnswers()
    {
        return $this->hasMany(UserMcqAnswer::class, 'user_id');
    }

    public function likedCases()
    {
        return $this->hasMany(CaseLike::class, 'user_id');
    }
}
