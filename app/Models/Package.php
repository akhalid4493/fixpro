<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $fillable = [
        'name_en', 
        'name_ar', 
        'description_en',
        'description_ar',
        'status',
        'price',
        'months',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id','id');
    }
}
