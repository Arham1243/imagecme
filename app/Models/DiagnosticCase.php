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

    public function comments()
    {
        return $this->hasMany(Comment::class, 'case_id');
    }

    public function getCaseNameAttribute()
    {
        return match ($this->case_type) {
            'share_image_diagnosis' => 'Case',
            'challenge_image_diagnosis' => 'Challenge Case',
            'ask_image_diagnosis' => 'Help Case',
            'ask_ai_image_diagnosis' => 'AI Case',
            default => 'Unknown Type',
        };
    }

    public function getFeaturedImageAttribute()
    {
        return $this->images[0]->path;
    }

    public function getImageTypesAttribute()
    {
        return $this->images->groupBy('type');
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($item) {
            if ($item->isForceDeleting()) {
                foreach ($item->images as $image) {
                    self::deleteImage($image->path);
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
