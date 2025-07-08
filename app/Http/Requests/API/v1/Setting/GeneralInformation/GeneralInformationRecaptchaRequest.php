<?php

namespace App\Http\Requests\API\v1\Setting\GeneralInformation;

use Illuminate\Foundation\Http\FormRequest;

class GeneralInformationRecaptchaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'recaptcha_secret_key' => ['required', 'string', 'max:200'],
            'recaptcha_site_key' => ['required', 'string', 'max:200'],
            'recaptcha_google_url_verify' => ['required', 'string', 'url', 'max:200'],
        ];
    }
}
