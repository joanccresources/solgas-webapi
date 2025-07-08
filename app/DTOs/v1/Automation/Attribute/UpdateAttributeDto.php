<?php

declare(strict_types=1);

namespace App\DTOs\v1\Automation\Attribute;

use App\Http\Requests\API\v1\Automation\AttributeRequest;

class UpdateAttributeDto
{
    public function __construct(
        public string $column_code,
        public string $name,
        public string|null $model_lookup,
        public array|null $attribute_options,
        public bool $is_required,
        public bool $is_unique,
        public string $model,
        public int $attribute_type_id,
        public bool|null $active
    ) {
    }

    public static function fromRequest(AttributeRequest $request): UpdateAttributeDto
    {
        return new self(
            column_code: $request->get('column_code'),
            name: $request->get('name'),
            model_lookup: $request->get('model_lookup'),
            attribute_options: $request->get('attribute_options'),
            is_required: (bool) $request->get('is_required'),
            is_unique: (bool) $request->get('is_unique'),
            model: $request->get('model'),
            attribute_type_id: $request->get('attribute_type_id'),
            active: (bool) $request->get('active')
        );
    }
}
