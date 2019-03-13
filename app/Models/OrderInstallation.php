<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderInstallation extends Model
{
    protected $fillable = [
        'product_id', 
        'order_id',
        'price',
        'qty',
        'warranty',
        'warranty_start',
        'warranty_end',
        'warranty_installation',
        'warranty_installation_start',
        'warranty_installation_end',
        'total',
    ];

    public function orderOfDetails()
    {       
        return $this->belongsTo('App\Models\Order' , 'order_id' ,'id');
    }


    public function product()
    {       
        return $this->belongsTo('App\Models\Product' , 'product_id' , 'id' );
    }
}
