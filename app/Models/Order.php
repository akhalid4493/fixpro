<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'note',
        'transID',
        'service',
        'subtotal',
        'off',
        'total',
        'method',
        'user_id',
        'technical_id',
        'preview_id',
        'order_status_id',
        'subtotal_profit',
        'total_profit'
    ];

    public function address()
    {
        return $this->belongsTo('App\Models\Address' , 'address_id' ,'id');
    }

    public function preview()
    {
        return $this->belongsTo('App\Models\Preview' , 'preview_id' ,'id');
    }

    public function orderStatus()
    {
        return $this->belongsTo('App\Models\OrderStatus','order_status_id','id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function technical()
    {
        return $this->belongsTo('App\Models\User','technical_id','id');
    }

    public function productsOfOrder()
    {
      return $this->hasMany('App\Models\OrderProduct');
    }

    public function installationsOfOrder()
    {
      return $this->hasMany('App\Models\OrderInstallation');
    }
}
