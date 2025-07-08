<?php

declare(strict_types=1);

namespace App\DTOs\v1\Page\Page;

use App\Http\Requests\API\v1\Page\PageRequest;
use Illuminate\Http\UploadedFile;

class UpdatePageDto
{
    public function __construct(
        public string $name,
        public string $slug,
        public string|null $seo_description,
        public string|null $seo_keywords,
        public UploadedFile|null $seo_image,
        public bool|null $active
    ) {}

    public static function fromRequest(PageRequest $request): UpdatePageDto
    {
        return new self(
            name: $request->get('name'),
            slug: $request->get('slug'),
            seo_description: $request->get('seo_description'),
            seo_keywords: $request->get('seo_keywords'),
            seo_image: $request->file('seo_image'),
            active: (bool) $request->get('active')
        );
    }
}
