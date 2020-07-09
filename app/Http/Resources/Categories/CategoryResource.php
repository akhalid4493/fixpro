<?php

namespace App\Http\Resources\Categories;

use App\Http\Resources\Services\ServiceResource;
use Illuminate\Http\Resources\Json\Resource;

class CategoryResource extends Resource
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
            'name'          => transText($this,'name'),
            'image'         => url($this->image),
            'services'      => ServiceResource::collection($this->whenLoaded('services')),
        ];
    }
}
