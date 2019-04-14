<?php

namespace App\Http\Resources\Orders;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\Installations\InstallationResource;

class OrderInstallationsResource extends Resource
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
            'orderQtyInstallation'          => $this->qty,
            'orderTotalInstallation'        => number_format($this->total,3),
            'orderPriceInstallation'        => number_format($this->price,3),
            'warranty'                      => $this->warranty,
            'warranty_start'                => $this->warranty_start,
            'warranty_end'                  => $this->warranty_end,
            'installationDetails'           => new InstallationResource($this->installation),
        ];
    }
}
