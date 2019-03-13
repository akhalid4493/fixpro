<?php

namespace App\Http\Resources\Services;

use Illuminate\Http\Resources\Json\Resource;

class ServiceResource extends Resource
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
        ];
    }
}
