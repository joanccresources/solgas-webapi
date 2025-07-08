<?php

declare(strict_types=1);

namespace App\DTOs\v1\Blog\Post;

use App\Http\Requests\API\v1\Blog\PostRequest;
use Illuminate\Http\UploadedFile;

class UpdatePostDto
{
    public function __construct(
        public string $title,
        public string $slug,
        public string $short_description,
        public string $content,
        public string $publication_at,
        public array|null $categories,
        public array|null $tags,
        public array|null $similar_posts,
        public bool|null $active,
        public UploadedFile|null $image,
        public UploadedFile|null $thumbnail
    ) {}

    public static function fromRequest(PostRequest $request): UpdatePostDto
    {
        return new self(
            title: $request->get('title'),
            slug: $request->get('slug'),
            short_description: $request->get('short_description'),
            content: $request->get('content'),
            categories: $request->get('categories'),
            tags: $request->get('tags'),
            similar_posts: $request->get('similar_posts'),
            publication_at: $request->get('publication_at'),
            active: (bool) $request->get('active'),
            image: $request->file('image'),
            thumbnail: $request->file('thumbnail'),
        );
    }
}
