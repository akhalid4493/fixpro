<?php

namespace App\Http\Resources\Orders;

use Illuminate\Http\Resources\Json\Resource;
use App\Http\Resources\User\AddressResource;
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
            'total'         => number_format($this->total,3),
            'payment_method'=> $this->method,
            'status_code'   => $this->orderStatus->id,
            'status'        => transText($this->orderStatus,'name'),
            'order_products'=> OrderDetailsResource::collection($this->productsOfOrder),
            'order_installations'=> OrderDetailsResource::collection($this->installationsOfOrder),
            'address'       => new AddressResource($this->preview->address),
            'user'          => new UserResource($this->user),
        ];
    }
}
