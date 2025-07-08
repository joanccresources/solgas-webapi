<?php

declare(strict_types=1);

namespace App\DTOs\v1\Content\ContentFooter;

use App\Http\Requests\API\v1\Content\ContentFooterRequest;

class UpdateContentFooterDto
{
    public function __construct(
        public string $name,
        public bool|null $active
    ) {}

    public static function fromRequest(ContentFooterRequest $request): UpdateContentFooterDto
    {
        return new self(
            name: $request->get('name'),
            active: (bool) $request->get('active')
        );
    }
}
