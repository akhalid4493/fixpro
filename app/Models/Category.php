<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
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
