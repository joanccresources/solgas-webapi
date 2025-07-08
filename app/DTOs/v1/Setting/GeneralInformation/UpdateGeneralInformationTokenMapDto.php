<?php

declare(strict_types=1);

namespace App\DTOs\v1\Setting\GeneralInformation;

use App\Http\Requests\API\v1\Setting\GeneralInformation\GeneralInformationTokenMapRequest;

class UpdateGeneralInformationTokenMapDto
{
    public function __construct(
        public string|null $token_map
    ) {}

    public static function fromRequest(GeneralInformationTokenMapRequest $request): UpdateGeneralInformationTokenMapDto
    {
        return new UpdateGeneralInformationTokenMapDto(
            token_map: $request->get('token_map')
        );
    }
}
