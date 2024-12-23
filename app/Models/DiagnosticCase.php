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
