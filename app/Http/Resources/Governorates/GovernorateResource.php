<?php

namespace App\Http\Resources\Governorates;

use App\Http\Resources\Provinces\ProvinceResource;
use Illuminate\Http\Resources\Json\Resource;

class GovernorateResource extends Resource
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
            'provinces'     => (count($this->province) <= 0) ? null : 
                               ProvinceResource::collection($this->province),
        ];
    }
}
