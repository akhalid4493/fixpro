<?php

namespace App\Http\Resources\Provinces;

use Illuminate\Http\Resources\Json\Resource;

class ProvinceResource extends Resource
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
        ];
    }
}