<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TechnicalShift extends Model
{
    protected $fillable = [
        'user_id',
        'from',
        'to',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id','id');
    }
}
