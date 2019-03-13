<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Installation extends Model
{
    protected $fillable = [
        'name_en', 
        'name_ar', 
        'description_en',
        'description_ar',
        'slug',
        'status',
        'price',
        'image',
        'seo_description_en',
        'seo_description_ar',
        'seo_keywords_en',
        'seo_keywords_ar',
    ];
}
