<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preview extends Model
{
    protected $fillable = [
        'note',
        'time',
        'user_id',
        'address_id',
        'preview_status_id',
        'seen',
        'seen_at',
        'note_from_admin',
    ];


    public function oldAddress()
    {
        return $this->belongsTo('App\Models\Address', 'address_id' ,'id');
    }

    public function address()
    {
        return $this->hasOne('App\Models\PreviewAddress');
    }

    public function previewStatus()
    {
        return $this->belongsTo('App\Models\PreviewStatus','preview_status_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function details()
    {
      return $this->hasMany('App\Models\PreviewDetail');
    }

    public function gallery()
    {
      return $this->hasMany('App\Models\PreviewGallery');
    }

    public function techGallery()
    {
      return $this->hasMany('App\Models\PreviewTechGallery');
    }

    public function technical()
    {
      return $this->hasOne('App\Models\TechnicalPreview');
    }
}
