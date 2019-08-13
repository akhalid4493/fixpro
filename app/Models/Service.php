<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'status',
        'slug',
        'image',
        'seo_description_en',
        'seo_description_ar',
        'seo_keywords_en',
        'seo_keywords_ar',
        'position'
    ];


    public function servicesOfTechnical()
    {
        return $this->belongsToMany('App\Models\User', 'technical_services');
    }
}
