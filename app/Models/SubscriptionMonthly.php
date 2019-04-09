<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionMonthly extends Model
{
    protected $fillable = [
        'paid_at',
        'price',
        'subscription_id'
    ];

    public function subscription()
    {       
        return $this->belongsTo('App\Models\Subscription' , 'subscription_id' ,'id');
    }
}
