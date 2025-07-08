<?php

namespace App\Rules;

use App\Models\GeneralInformation;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class RecaptchaLow implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $general_information = GeneralInformation::orderBy('created_at', 'ASC')->first();

        if (
            !$general_information ||
            $general_information->recaptcha_google_url_verify === "" ||
            $general_information->recaptcha_secret_key === "" ||
            $general_information->recaptcha_google_url_verify === null ||
            $general_information->recaptcha_secret_key === null  ||
            $general_information->recaptcha_status === 0
        ) {
            return;
        }

        $response = Http::asForm()->post($general_information->recaptcha_google_url_verify, [
            'secret' => $general_information->recaptcha_secret_key,
            'response' => $value
        ])->object();

        // Verifica si el response es válido antes de acceder a `score`
        $score = $response->score ?? 0;

        // Falla si success es falso o el score es menor a 0.3
        if (!$response->success || $score < 0.3) {
            $fail("La verificación de reCAPTCHA ha fallado. Intente de nuevo.");
        }
    }
}
