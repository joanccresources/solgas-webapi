<?php

declare(strict_types=1);

namespace App\DTOs\v1\Content\ContentHeader;

use App\Http\Requests\API\v1\Content\ContentHeaderRequest;

class CreateContentHeaderDto
{
    public function __construct(
        public string $name,
        public bool|null $active
    ) {}

    public static function fromRequest(ContentHeaderRequest $request): CreateContentHeaderDto
    {
        return new self(
            name: $request->get('name'),
            active: (bool) $request->get('active')
        );
    }
}
