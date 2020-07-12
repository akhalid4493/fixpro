<?php

namespace App\Http\Resources\Orders;

use App\Http\Resources\Previews\PreviewResource;
use App\Http\Resources\User\AddressResource;
use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\User\UserResource;

class OrderResource extends Resource
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
            'subtotal'      => number_format($this->subtotal,3),
            'off'           => $this->off ? number_format($this->off,3) : null,
            'service'       => number_format($this->service,3),
            'total'         => number_format($this->total,3),
            'payment_method'=> $this->method,
            'status_code'   => $this->orderStatus->id,
            'status'        => transText($this->orderStatus,'name'),
            'order_products'=> OrderDetailsResource::collection($this->productsOfOrder),
            'order_installations'=> OrderInstallationsResource::collection($this->installationsOfOrder),
            'preview'       => new PreviewResource($this->preview),
            'address'       => new AddressResource($this->preview->address),
            'user'          => new UserResource($this->user),
        ];
    }
}
