<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Governorate extends Model
{
    protected $fillable = [
        'name_en', 
        'name_ar', 
        'status' ,
    ];

    public function province()
    {       
        return $this->hasMany('App\Models\Province');
    }

    public function locationsOfTechnical()
    {
        return $this->belongsToMany('App\Models\User', 'technical_locations');
    }
}