<?php

declare(strict_types=1);

namespace App\DTOs\v1\Profile;

use App\Http\Requests\API\v1\Profile\UpdatePersonalInformationRequest;

class UpdatePersonalInformationDto
{
    public function __construct(
        public string $name,
        public string|null $phone

    ) {
    }

    public static function fromRequest(UpdatePersonalInformationRequest $request): UpdatePersonalInformationDto
    {
        return new UpdatePersonalInformationDto(
            name: $request->get('name'),
            phone: $request->get('phone')
        );
    }
}
