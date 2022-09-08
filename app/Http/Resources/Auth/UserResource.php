<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\RoleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'email' => $this->{'email'},
            'profile' => new ProfileResource($this->whenLoaded('profile')),
            'status' => $this->{'status'},
            'roles' => RoleResource::collection($this->whenLoaded('roles')),
            'created_at' => $this->{'created_at'},
        ];
    }
}
