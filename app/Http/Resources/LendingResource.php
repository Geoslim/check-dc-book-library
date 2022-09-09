<?php

namespace App\Http\Resources;

use App\Http\Resources\Auth\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LendingResource extends JsonResource
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
            'book' => new BookResource($this->whenLoaded('book')),
            'user' => new UserResource($this->whenLoaded('user')),
            'date_time_borrowed' => $this->{'date_time_borrowed'},
            'date_time_due' => $this->{'date_time_due'},
            'date_time_returned' => $this->{'date_time_returned'},
            'points' => $this->{'points'},
            'status' => $this->{'status'},
        ];
    }
}
