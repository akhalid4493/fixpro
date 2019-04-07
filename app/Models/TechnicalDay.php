<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalDay extends Model
{
    protected $fillable = [
        'user_id',
        'day',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id','id');
    }
}
