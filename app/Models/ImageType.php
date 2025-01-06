<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ImageType extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function cases()
    {
        return $this->hasMany(DiagnosticCase::class, 'type');
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($item) {
            self::deleteImage($item->featured_image);
        });
    }

    public static function deleteImage($path)
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
