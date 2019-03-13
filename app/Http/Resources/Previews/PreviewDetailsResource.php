<?php

namespace App\Http\Resources\Previews;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\Services\ServiceResource;

class PreviewDetailsResource extends Resource
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
            'servicesDetails'  => new ServiceResource($this->service),
        ];
    }
}
