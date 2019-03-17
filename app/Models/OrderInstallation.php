<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderInstallation extends Model
{
    protected $fillable = [
        'installation_id', 
        'order_id',
        'price',
        'qty',
        'warranty',
        'warranty_start',
        'warranty_end',
        'total',
    ];

    public function orderOfDetails()
    {       
        return $this->belongsTo('App\Models\Order' , 'order_id' ,'id');
    }


    public function installation()
    {       
        return $this->belongsTo('App\Models\Installation' , 'installation_id' , 'id' );
    }
}
