<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'name_en', 
        'name_ar', 
        'description_en',
        'description_ar',
        'status',
        'slug',
        'page_id',
        'seo_description_en',
        'seo_description_ar',
        'seo_keywords_en',
        'seo_keywords_ar',
    ];

    public function parent()
    {
        return $this->belongsTo('App\Models\Page', 'page_id','id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Page', 'page_id','id');
    }
}
