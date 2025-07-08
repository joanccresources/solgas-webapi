<?php

namespace App\Http\Resources\v1\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostPublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'content' => $this->content,
            'image' => $this->image,
            'image_format' => $this->image_format,
            'thumbnail' => $this->thumbnail,
            'thumbnail_format' => $this->thumbnail_format,
            'like' => $this->like,
            'shared' => $this->shared,
            'active' => $this->active,

            'tag_posts_rel' => TagPostPublicResource::collection($this->whenLoaded('tagPostRels')),
            'category_posts_rel' => CategoryPostPublicResource::collection($this->whenLoaded('categoryPostRels')),
            'comments' => CommentPostPublicResource::collection(collect($this->commentRels)),

            'similar_post_rels' => PostSimilarPublicResource::collection($this->whenLoaded('similarPostRels')),

            'publication_at' => $this->publication_at,
            'publication_at_format' => $this->publication_at_format,
            'publication_at_format_2' => $this->publication_at_format2,
            'publication_at_format_3' => $this->publication_at_format3,
        ];
    }
}
