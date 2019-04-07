<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreviewDate extends Model
{
    protected $fillable = [
        'preview_id',
        'service_id',
        'governorate_id',
        'date'
    ];
    
    public function preview()
    {
        return $this->belongsTo('App\Models\Preview','preview_id','id');
    }

    public function governorate()
    {
        return $this->belongsTo('App\Models\Governorate','governorate_id','id');
    }

    public function service()
    {
        return $this->belongsTo('App\Models\Service','service_id','id');
    }

    public function technicalOfPreview()
    {
        return $this->belongsTo('App\Models\Preview', 'preview_id');
    }
}
