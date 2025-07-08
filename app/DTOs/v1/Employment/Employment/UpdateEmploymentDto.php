<?php

declare(strict_types=1);

namespace App\DTOs\v1\Employment\Employment;

use App\Http\Requests\API\v1\Employment\EmploymentRequest;

class UpdateEmploymentDto
{
    public function __construct(
        public string $title,
        public string $description,
        public string $address,
        public string $code_ubigeo,
        public string $posted_at,
        public int $employment_type_id,
        public int $employment_area_id,
        public array|null $similar_employments,
        public bool|null $active
    ) {}

    public static function fromRequest(EmploymentRequest $request): UpdateEmploymentDto
    {
        return new self(
            title: $request->get('title'),
            description: $request->get('description'),
            address: $request->get('address'),
            code_ubigeo: $request->get('code_ubigeo'),
            posted_at: $request->get('posted_at'),
            employment_type_id: $request->get('employment_type_id'),
            employment_area_id: $request->get('employment_area_id'),
            similar_employments: $request->get('similar_employments'),
            active: (bool) $request->get('active')
        );
    }
}
