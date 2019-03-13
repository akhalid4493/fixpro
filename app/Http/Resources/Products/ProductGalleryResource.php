<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\Resource;

class ProductGalleryResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
         return [
            'id'            => $this->id,
            'image'         => url($this->image),
        ];
    }
}
