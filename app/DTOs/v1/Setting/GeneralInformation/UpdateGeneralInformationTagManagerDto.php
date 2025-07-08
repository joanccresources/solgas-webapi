<?php

declare(strict_types=1);

namespace App\DTOs\v1\Setting\GeneralInformation;

use App\Http\Requests\API\v1\Setting\GeneralInformation\GeneralInformationTagManagerRequest;

class UpdateGeneralInformationTagManagerDto
{
    public function __construct(
        public string|null $google_tag_manager_id
    ) {}

    public static function fromRequest(GeneralInformationTagManagerRequest $request): UpdateGeneralInformationTagManagerDto
    {
        return new UpdateGeneralInformationTagManagerDto(
            google_tag_manager_id: $request->get('google_tag_manager_id')
        );
    }
}
