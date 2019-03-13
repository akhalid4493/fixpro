<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
	protected $fillable = [
        'name_en', 
	    'name_ar', 
	    'governorate_id',
	    'status',
    ];
    
	public function governorate()
    {       
        return $this->belongsTo('App\Models\Governorate' , 'governorate_id' ,'id');
    }
}