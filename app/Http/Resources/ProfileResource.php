<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
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
            'first_name' => $this->{'first_name'},
            'last_name' => $this->{'last_name'},
            'username' => $this->{'username'},
            'age' => $this->{'age'},
            'address' => $this->{'address'},
        ];
    }
}
