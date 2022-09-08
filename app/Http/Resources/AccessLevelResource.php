<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AccessLevelResource extends JsonResource
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
            'name' => $this->{'name'},
            'min_age' => $this->{'min_age'},
            'max_age' => $this->{'max_age'},
            'lending_point' => $this->{'lending_point'},
        ];
    }
}
