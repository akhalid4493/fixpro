<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
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
        'province_id',
        'user_id',
    ];

    public function addressProvince()
    {       
        return $this->belongsTo('App\Models\Province' , 'province_id' ,'id');
    }
}
