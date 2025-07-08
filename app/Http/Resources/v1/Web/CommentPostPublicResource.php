<?php

namespace App\Http\Resources\v1\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentPostPublicResource extends JsonResource
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
            'comment' => $this->comment,
            'comments' => CommentPostPublicResource::collection(collect($this->comments)),
            'user' => new UserCommentPublicResource($this->userRel),
            'created_at_format' => $this->created_at_format,
            'created_at_format2' => $this->created_at_format2
        ];
    }
}
