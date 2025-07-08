<?php

declare(strict_types=1);

namespace App\DTOs\v1\Content\ContentFooterMenu;

use Illuminate\Http\UploadedFile;
use App\Http\Requests\API\v1\Content\ContentFooterMenuRequest;

class UpdateContentFooterMenuDto
{
    public function __construct(
        public string $name,
        public UploadedFile|string|null $content,
        public string $content_footer_id,
        public string|null $content_footer_menu_id,
        public string $content_menu_type_id,
        public bool|null $active
    ) {}

    public static function fromRequest(ContentFooterMenuRequest $request): UpdateContentFooterMenuDto
    {
        return new self(
            name: $request->get('name'),
            content: $request->hasFile('content') ? $request->file('content') : $request->get('content'),
            content_footer_id: $request->get('content_footer_id'),
            content_footer_menu_id: $request->get('content_footer_menu_id'),
            content_menu_type_id: $request->get('content_menu_type_id'),
            active: (bool) $request->get('active')
        );
    }
}
