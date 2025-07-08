<?php

declare(strict_types=1);

namespace App\DTOs\v1\Setting\GeneralInformation;

use App\Http\Requests\API\v1\Setting\GeneralInformation\GeneralInformationCookieRequest;
use Illuminate\Http\UploadedFile;

class UpdateGeneralInformationCookieDto
{
    public function __construct(
        public string|null $title_cookie,
        public string|null $description_cookie,
        public string|null $text_button_necessary_cookie,
        public string|null $text_button_allow_cookie,
        public UploadedFile|null $more_information_cookie,
    ) {}

    public static function fromRequest(GeneralInformationCookieRequest $request): UpdateGeneralInformationCookieDto
    {
        return new UpdateGeneralInformationCookieDto(
            title_cookie: $request->get('title_cookie'),
            description_cookie: $request->get('description_cookie'),
            text_button_necessary_cookie: $request->get('text_button_necessary_cookie'),
            text_button_allow_cookie: $request->get('text_button_allow_cookie'),
            more_information_cookie: $request->file('more_information_cookie'),
        );
    }
}
