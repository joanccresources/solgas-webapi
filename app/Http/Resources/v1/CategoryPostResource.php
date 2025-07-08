<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryPostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,

            'post_id' => $this->post_id,
            'category_id' => $this->category_id,

            'category_rel' => new CategoryResource($this->whenLoaded('categoryRel')),
            'post_rel' => new PostResource($this->whenLoaded('postRel'))
        ];
    }
}
