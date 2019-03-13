<?php

namespace App\Http\Resources\Previews;

use Illuminate\Http\Resources\Json\Resource;

class PreviewGalleryResource extends Resource
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
            'image'         => url($this->image),
        ];
    }
}
