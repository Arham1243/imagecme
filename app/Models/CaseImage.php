<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CaseImage extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function case()
    {
        return $this->belongsTo(DiagnosticCase::class);
    }

    public function imageType()
    {
        return $this->belongsTo(ImageType::class, 'type', 'id');
    }
}
