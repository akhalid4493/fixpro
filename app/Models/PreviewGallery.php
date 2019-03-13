<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreviewGallery extends Model
{
	protected $fillable = [
        'preview_id', 
        'image',
    ];

    public function preview()
    {
        return $this->belongsTo('App\Models\Preview', 'preview_id','id');
    }
}
