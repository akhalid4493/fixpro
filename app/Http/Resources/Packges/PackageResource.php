<?php

namespace App\Http\Resources\Packges;

use Illuminate\Http\Resources\Json\Resource;

class PackageResource extends Resource
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
            'months'        => $this->months,
            'price'         => Price($this->price),
            'name'          => transText($this,'name'),
            'description'   => transText($this,'description'),
        ];
    }
}
