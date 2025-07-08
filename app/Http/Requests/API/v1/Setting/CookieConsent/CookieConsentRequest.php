<?php

namespace App\Http\Requests\API\v1\Setting\CookieConsent;

use App\Rules\RecaptchaLow;
use Illuminate\Foundation\Http\FormRequest;

class CookieConsentRequest extends FormRequest
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
            'cookie_preferences' => ['required', 'array'],
            'cookie_preferences.necessary' => ['required', 'array'],
            'cookie_preferences.necessary.contact_form_captcha' => ['required', 'boolean'],
            'cookie_preferences.necessary.google_maps' => ['required', 'boolean'],
            'cookie_preferences.analytics' => ['nullable', 'array'],
            'cookie_preferences.analytics.google_tag_manager_analytics' => ['nullable', 'boolean'],
            'cookie_preferences.marketing' => ['nullable', 'array'],
            'cookie_preferences.marketing.google_tag_manager_marketing' => ['nullable', 'boolean'],

            'q_recaptcha' => ['required', new RecaptchaLow()],
        ];
    }
}
