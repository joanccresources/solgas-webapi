<?php

declare(strict_types=1);

namespace App\DTOs\v1\Setting\GeneralInformation;

use App\Http\Requests\API\v1\Setting\GeneralInformation\GeneralInformationRequest;
use Illuminate\Http\UploadedFile;

class UpdateGeneralInformationDto
{
    public function __construct(
        public UploadedFile|null $logo_principal,
        public UploadedFile|null $logo_footer,
        public UploadedFile|null $logo_icon,
        public UploadedFile|null $logo_email,
        public string|null $phone,
        public string|null $whatsapp,
    ) {}

    public static function fromRequest(GeneralInformationRequest $request): UpdateGeneralInformationDto
    {
        return new UpdateGeneralInformationDto(
            logo_principal: $request->file('logo_principal'),
            logo_footer: $request->file('logo_footer'),
            logo_icon: $request->file('logo_icon'),
            logo_email: $request->file('logo_email'),
            phone: $request->get('phone'),
            whatsapp: $request->get('whatsapp'),
        );
    }
}
