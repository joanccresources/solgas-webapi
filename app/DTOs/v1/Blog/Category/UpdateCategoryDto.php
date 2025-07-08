<?php

declare(strict_types=1);

namespace App\DTOs\v1\Blog\Category;

use App\Http\Requests\API\v1\Blog\CategoryRequest;

class UpdateCategoryDto
{
    public function __construct(
        public string $name,
        public string $background_color,
        public string $point_color,
        public string $slug,
        public bool|null $active
    ) {}

    public static function fromRequest(CategoryRequest $request): UpdateCategoryDto
    {
        return new self(
            name: $request->get('name'),
            background_color: $request->get('background_color'),
            point_color: $request->get('point_color'),
            slug: $request->get('slug'),
            active: (bool) $request->get('active')
        );
    }
}
