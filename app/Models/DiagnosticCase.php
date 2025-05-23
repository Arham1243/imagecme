<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class DiagnosticCase extends Model
{
    use SoftDeletes;

    protected $table = 'cases';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function images()
    {
        return $this->hasMany(CaseImage::class, 'case_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function views()
    {
        return $this->hasMany(CaseView::class, 'case_id');
    }

    public function comments()
    {
        return $this->hasMany(CaseComment::class, 'case_id');
    }

    public function getFeaturedImageAttribute()
    {
        return $this->images[0]->path ?? 'admin/assets/images/placeholder.png';
    }

    public function getImageTypesAttribute()
    {
        return $this->images->groupBy('type');
    }

    public function commentReplies()
    {
        return $this->hasManyThrough(CaseCommentReply::class, CaseComment::class);
    }

    public function likes()
    {
        return $this->hasMany(CaseLike::class, 'case_id');
    }

    public function userAnswers()
    {
        return $this->hasMany(UserMcqAnswer::class, 'case_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($item) {
            if ($item->isForceDeleting()) {
                $item->images()->delete();
                foreach ($item->images as $image) {
                    self::deleteImage($image->path);
                }
                if ($item->userAnswers()->exists()) {
                    $item->userAnswers()->delete();
                }
            }
        });
    }

    public static function deleteImage($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
