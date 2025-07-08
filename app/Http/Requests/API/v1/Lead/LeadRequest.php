<?php

namespace App\Http\Requests\API\v1\Lead;

use App\Rules\RecaptchaLow;
use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
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
            'full_name' => ['bail', 'required', 'string', 'max:200'],
            'email' => ['bail', 'required', 'email:rfc,dns', 'max:200'],
            'message' => ['bail', 'required', 'string', 'max:1000'],
            'q_recaptcha' => ['required', new RecaptchaLow()],
        ];
    }
}
