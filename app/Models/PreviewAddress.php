<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreviewAddress extends Model
{
    protected $fillable = [
        'lat',
        'lang',
        'block',
        'street',
        'building',
        'house_no',
        'floor',
        'address',
        'note',
        'user_id',
        'province_id',
        'preview_id'
    ];

    public function addressProvince()
    {       
        return $this->belongsTo('App\Models\Province' , 'province_id' ,'id');
    }

    public function user()
    {       
        return $this->belongsTo('App\Models\User' , 'user_id' ,'id');
    }

    public function preview()
    {       
        return $this->belongsTo('App\Models\Preview' , 'preview_id' ,'id');
    }
}
