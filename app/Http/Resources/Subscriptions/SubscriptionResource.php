<?php

namespace App\Http\Resources\Subscriptions;

use Illuminate\Http\Resources\Json\Resource;

class SubscriptionResource extends Resource
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
            'id'                     => $this->id,
            'start_at'               => $this->start_at,
            'end_at'                 => $this->end_at,
            'note'                   => $this->note,
            'next_billing'           => $this->next_billing,
            'total'                  => Price($this->total),
            'billingـreminder'       => billingRemender($this),
        ];
    }
}
