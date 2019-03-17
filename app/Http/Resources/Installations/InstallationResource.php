<?php

namespace App\Http\Resources\Installations;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\UserResource;

class InstallationResource extends Resource
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
            'price'         => number_format($this->price,3),
            'image'         => url($this->image),
        ];
    }
}
