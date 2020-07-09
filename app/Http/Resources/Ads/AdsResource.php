<?php

namespace App\Http\Resources\Ads;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\UserResource;

class AdsResource extends Resource
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
            'link'          => $this->link,
        ];
    }
}
