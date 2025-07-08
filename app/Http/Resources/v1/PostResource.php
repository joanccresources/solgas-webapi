<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    private const FOLDER_IMAGE =  DIRECTORY_SEPARATOR . 'private' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'users' . DIRECTORY_SEPARATOR;

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'short_description' => $this->short_description,
            'content' => $this->content,
            'image' => $this->image,
            'image_format' => $this->image_format,
            'image_format_2' => $this->image_format2,
            'thumbnail' => $this->thumbnail,
            'thumbnail_format' => $this->thumbnail_format,
            'thumbnail_format_2' => $this->thumbnail_format2,
            'view' => $this->view,
            'like' => $this->like,
            'shared' => $this->shared,
            'active' => $this->active,
            'user_id' => $this->user_id,

            'tag_posts_count' => $this->whenCounted('tagPostRels'),
            'category_posts_count' => $this->whenCounted('categoryPostRels'),

            'tag_posts_rel' => TagPostResource::collection($this->whenLoaded('tagPostRels')),
            'category_posts_rel' => CategoryPostResource::collection($this->whenLoaded('categoryPostRels')),
            'comments' => $this->commentRels,

            'similar_post_rels_count' => $this->whenCounted('similarPostRels'),
            'similar_post_rels' => PostSimilarResource::collection($this->whenLoaded('similarPostRels')),

            'user_rel' => $this->whenLoaded('userRel', function () {
                return [
                    'id' => $this->userRel->id,
                    'name' => $this->userRel->name,
                    'image' => $this->userRel->image,
                    'path' => $this->userRel->image ? self::FOLDER_IMAGE . $this->userRel->image : '',
                    'avatar_initials' => $this->userRel->avatar_initials,
                ];
            }),

            'created_at' => $this->created_at,
            'created_at_format' => $this->created_at_format,
            'created_at_format_2' => $this->created_at_format2,
            'updated_at' => $this->updated_at,
            'updated_at_format' => $this->updated_at_format,
            'updated_at_format_2' => $this->updated_at_format2,
            'publication_at' => $this->publication_at,
            'publication_at_format' => $this->publication_at_format,
            'publication_at_format_2' => $this->publication_at_format2,
            'publication_at_format_3' => $this->publication_at_format3,
        ];
    }
}
