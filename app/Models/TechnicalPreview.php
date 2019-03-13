<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalPreview extends Model
{
    protected $fillable = [
        'user_id',
        'preview_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function technicalOfPreview()
    {
        return $this->belongsToMany('App\Models\User', 'technical_previews');
    }
}
