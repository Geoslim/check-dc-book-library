<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->{'id'},
            'plan' => new PlanResource($this->whenLoaded('plan')),
            'status' => $this->{'status'},
            'start_date' => $this->{'start_date'},
            'end_date' => $this->{'end_date'},
        ];
    }
}
