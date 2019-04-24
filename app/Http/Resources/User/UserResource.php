<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Subscriptions\SubscriptionResource;
use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
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
            'email'         => $this->email,
            'mobile'        => $this->mobile,
            'name'          => $this->name,
            'avatar'        => url($this->image),
            'subscription'  => $this->checkSubscription ? new SubscriptionResource($this->hasSubscription) : null,
        ];
    }
}
