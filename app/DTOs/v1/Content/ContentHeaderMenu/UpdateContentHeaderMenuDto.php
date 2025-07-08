<?php

declare(strict_types=1);

namespace App\DTOs\v1\Content\ContentHeaderMenu;

use Illuminate\Http\UploadedFile;
use App\Http\Requests\API\v1\Content\ContentHeaderMenuRequest;

class UpdateContentHeaderMenuDto
{
    public function __construct(
        public string $name,
        public UploadedFile|string|null $content,
        public string $content_header_id,
        public string|null $content_header_menu_id,
        public string $content_menu_type_id,
        public bool|null $active
    ) {}

    public static function fromRequest(ContentHeaderMenuRequest $request): UpdateContentHeaderMenuDto
    {
        return new self(
            name: $request->get('name'),
            content: $request->hasFile('content') ? $request->file('content') : $request->get('content'),
            content_header_id: $request->get('content_header_id'),
            content_header_menu_id: $request->get('content_header_menu_id'),
            content_menu_type_id: $request->get('content_menu_type_id'),
            active: (bool) $request->get('active')
        );
    }
}
