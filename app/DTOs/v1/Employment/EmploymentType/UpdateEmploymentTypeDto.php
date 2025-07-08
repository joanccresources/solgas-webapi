<?php

declare(strict_types=1);

namespace App\DTOs\v1\Employment\EmploymentType;

use App\Http\Requests\API\v1\Employment\EmploymentTypeRequest;

class UpdateEmploymentTypeDto
{
    public function __construct(
        public string $name,
        public bool|null $active
    ) {}

    public static function fromRequest(EmploymentTypeRequest $request): UpdateEmploymentTypeDto
    {
        return new self(
            name: $request->get('name'),
            active: (bool) $request->get('active')
        );
    }
}
