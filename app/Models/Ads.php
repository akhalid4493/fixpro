<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    protected $table    = 'ads';

    protected $fillable = [
        'name_en',
        'name_ar',
        'status',
        'image',
        'start_at',
        'end_at',
        'image',
        'link'
    ];

    public function products()
    {
        return $this->belongsToMany('App\Models\Product', 'product_categories');
    }

    public function installations()
    {
        return $this->belongsToMany('App\Models\Installation', 'installation_categories');
    }

    public function categoriesOfTechnical()
    {
        return $this->belongsToMany('App\Models\User', 'technical_categories');
    }
}
