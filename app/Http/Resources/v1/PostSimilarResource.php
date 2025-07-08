<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostSimilarResource extends JsonResource
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
            'post_similar_id' => $this->post_similar_id,

            'post_rel' => new PostResource($this->whenLoaded('postRel')),
            'similar_post_rel' => new PostResource($this->whenLoaded('similarPostRel'))
        ];
    }
}
