<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $fillable = [
        'package_id',
        'user_id',
        'total',
        'start_at',
        'end_at',
        'status',
        'isCanceled',
        'next_billing',
        'note'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User' , 'user_id' ,'id');
    }

    public function monthlyBilling()
    {
      return $this->hasMany('App\Models\SubscriptionMonthly');
    }

    public function package()
    {
        return $this->belongsTo('App\Models\Package', 'package_id','id');
    }
}
