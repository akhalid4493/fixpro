<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\Resource;
use JWTAuth;
use Auth;

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
            'subscription'  => $this->checkSubscription ? true : false,
        ];
    }
}
