<?php

namespace App\Http\Resources\Previews;

use App\Http\Resources\User\AddressResource;
use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\User\UserResource;

class PreviewResource extends Resource
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
            'id'                    => $this->id,
            'status'                => transText($this->previewStatus,'name'),
            'status_code'           => $this->previewStatus->id,
            'time'                  => $this->time,
            'total'                 => $this->total,
            'note_from_admin'       => $this->note_from_admin,
            'note_from_technical'   => $this->note_from_technical,
            'note'                  => $this->note,
            'preview_details'       => PreviewDetailsResource::collection($this->details),
            'preview_gallery'       => PreviewGalleryResource::collection($this->gallery),
            'address'               => new AddressResource($this->address),
            'user'                  => new UserResource($this->user),
        ];
    }
}
