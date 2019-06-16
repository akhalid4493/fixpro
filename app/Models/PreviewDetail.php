<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreviewDetail extends Model
{
    protected $fillable = [
        'service_id',
        'preview_id',
    ];


    public function previewOfDetails()
    {
        return $this->belongsTo('App\Models\Previews' , 'preview_id' ,'id');
    }


    public function service()
    {
        return $this->belongsTo('App\Models\Service' , 'service_id' , 'id' );
    }
}
