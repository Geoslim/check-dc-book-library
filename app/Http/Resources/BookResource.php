<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
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
            'title' => $this->{'title'},
            'edition' => $this->{'edition'},
            'description' => $this->{'description'},
            'prologue' => $this->{'prologue'},
            'status' => $this->{'status'},
            'authors' => UserResource::collection($this->whenLoaded('authors')),
            'access_levels' => AccessLevelResource::collection($this->whenLoaded('accessLevels')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'plans' => PlanResource::collection($this->whenLoaded('plans')),
            'created_at' => $this->{'created_at'},
        ];
    }
}
