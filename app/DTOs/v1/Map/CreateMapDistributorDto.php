<?php

declare(strict_types=1);

namespace App\DTOs\v1\Map;

use App\Http\Requests\API\v1\Map\MapDistributorRequest;

class CreateMapDistributorDto
{
    public function __construct(
        public string $name,
        public string $address,
        public string|null $schedule,
        public string|null $phone,
        public float|null $latitude,
        public float|null $longitude,
        public string|null $code_department,
        public string|null $code_province,
        public string|null $code_district,
        public string|null $coverage_area,
        public bool|null $active
    ) {}

    public static function fromRequest(MapDistributorRequest $request): CreateMapDistributorDto
    {
        return new self(
            name: $request->get('name'),
            address: $request->get('address'),
            schedule: $request->get('schedule'),
            phone: $request->get('phone'),
            latitude: $request->get('latitude'),
            longitude: $request->get('longitude'),
            code_department: $request->get('code_department'),
            code_province: $request->get('code_province'),
            code_district: $request->get('code_district'),
            coverage_area: $request->get('coverage_area'),
            active: (bool) $request->get('active')
        );
    }
}
