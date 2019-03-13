<?php

namespace App\Http\Resources\Products;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\UserResource;

class ProductResource extends Resource
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
            'warranty'      => $this->warranty,
            'name'          => transText($this,'name'),
            'price'         => number_format($this->price,3),
            'image'         => url($this->image),
        ];
    }
}
