<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Provinces\ProvinceResource;
use Illuminate\Http\Resources\Json\Resource;

class AddressResource extends Resource
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
            'lat'           => $this->lat,
            'lang'          => $this->lang,
            'block'         => $this->block,
            'street'        => $this->street,
            'building'      => $this->building,
            'floor'         => $this->floor,
            'house_no'      => $this->house_no,
            'note'          => $this->note,
            'address'       => $this->address,
            'province'      => new ProvinceResource($this->addressProvince),
        ];
    }
}
