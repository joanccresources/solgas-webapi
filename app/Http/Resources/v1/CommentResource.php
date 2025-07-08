<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'commentable_type' => $this->commentable_type,
            'commentable_id' => $this->commentable_id,
            'comment' => $this->comment,
            'is_approved' => (int) $this->is_approved,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_at_format' => $this->created_at_format,
            'created_at_format2' => $this->created_at_format2,
            'updated_at_format' => $this->updated_at_format,
            'updated_at_format2' => $this->updated_at_format2,
            'user_rel' => $this->whenLoaded('userRel'),
            'comments' => CommentResource::collection($this->whenLoaded('comments')),
        ];
    }
}
