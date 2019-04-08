<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'package_id',
        'user_id',
        'start_at',
        'end_at',
        'total',
    ];

    public function user()
    {       
        return $this->belongsTo('App\Models\User' , 'user_id' ,'id');
    }
}
