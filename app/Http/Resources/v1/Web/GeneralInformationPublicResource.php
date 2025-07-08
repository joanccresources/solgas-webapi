<?php

namespace App\Http\Resources\v1\Web;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GeneralInformationPublicResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'logo_principal' => $this->logo_principal,
            'logo_footer' => $this->logo_footer,
            'logo_icon' => $this->logo_icon,
            'logo_email' => $this->logo_email,
            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'recaptcha_site_key' => $this->recaptcha_site_key,
            'google_tag_manager_id' => $this->google_tag_manager_id,
            'token_map' => $this->token_map,

            'title_cookie' => $this->title_cookie,
            'description_cookie' => $this->description_cookie,
            'text_button_necessary_cookie' => $this->text_button_necessary_cookie,
            'text_button_allow_cookie' => $this->text_button_allow_cookie,
            'more_information_cookie' => $this->more_information_cookie,
            'more_information_cookie_format' => $this->more_information_cookie_format,

            'logo_principal_format' => $this->logo_principal_format,
            'logo_footer_format' => $this->logo_footer_format,
            'logo_icon_format' => $this->logo_icon_format,
            'logo_email_format' => $this->logo_email_format,
        ];
    }
}
