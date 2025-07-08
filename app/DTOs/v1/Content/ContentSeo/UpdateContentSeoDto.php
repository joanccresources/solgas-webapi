<?php

declare(strict_types=1);

namespace App\DTOs\v1\Content\ContentSeo;

use App\Http\Requests\API\v1\Content\ContentSeoRequest;
use Illuminate\Http\UploadedFile;

class UpdateContentSeoDto
{
    public function __construct(
        public string $name,
        public string $seo_description,
        public string $seo_keywords,
        public UploadedFile|null $seo_image
    ) {}

    public static function fromRequest(ContentSeoRequest $request): UpdateContentSeoDto
    {
        return new self(
            name: $request->get('name'),
            seo_description: $request->get('seo_description'),
            seo_keywords: $request->get('seo_keywords'),
            seo_image: $request->file('seo_image'),
        );
    }
}
