<?php

declare(strict_types=1);

namespace App\DTOs\v1\Blog\Tag;

use App\Http\Requests\API\v1\Blog\TagRequest;

class UpdateTagDto
{
    public function __construct(
        public string $name,
        public string $slug,
        public bool|null $active
    ) {}

    public static function fromRequest(TagRequest $request): UpdateTagDto
    {
        return new self(
            name: $request->get('name'),
            slug: $request->get('slug'),
            active: (bool) $request->get('active')
        );
    }
}
