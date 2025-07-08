<?php

declare(strict_types=1);

namespace App\DTOs\v1\Setting\GeneralInformation;

use App\Http\Requests\API\v1\Setting\GeneralInformation\GeneralInformationRecaptchaRequest;

class UpdateGeneralInformationRecaptchaDto
{
    public function __construct(
        public string|null $recaptcha_secret_key,
        public string|null $recaptcha_site_key,
        public string|null $recaptcha_google_url_verify,
    ) {}

    public static function fromRequest(GeneralInformationRecaptchaRequest $request): UpdateGeneralInformationRecaptchaDto
    {
        return new UpdateGeneralInformationRecaptchaDto(
            recaptcha_secret_key: $request->get('recaptcha_secret_key'),
            recaptcha_site_key: $request->get('recaptcha_site_key'),
            recaptcha_google_url_verify: $request->get('recaptcha_google_url_verify'),
        );
    }
}
