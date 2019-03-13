<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'user_id',
        'package_id',
        'start_at',
        'end_at',
        'price',
    ];

    public function user()
    {       
        return $this->belongsTo('App\Models\User' , 'user_id' ,'id');
    }
}
