<?php

declare(strict_types=1);

namespace App\DTOs\v1\Employment\EmploymentArea;

use App\Http\Requests\API\v1\Employment\EmploymentAreaRequest;

class CreateEmploymentAreaDto
{
    public function __construct(
        public string $name,
        public bool|null $active
    ) {}

    public static function fromRequest(EmploymentAreaRequest $request): CreateEmploymentAreaDto
    {
        return new self(
            name: $request->get('name'),
            active: (bool) $request->get('active')
        );
    }
}
