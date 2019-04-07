<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalPreview extends Model
{
    protected $fillable = [
        'user_id',
        'preview_id',
        'service_id',
        'province_id',
        'date'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function province()
    {
        return $this->belongsTo('App\Models\Province','province_id','id');
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service','service_id','id');
    }

    public function technicalOfPreview()
    {
        return $this->belongsToMany('App\Models\User', 'technical_previews');
    }
}
