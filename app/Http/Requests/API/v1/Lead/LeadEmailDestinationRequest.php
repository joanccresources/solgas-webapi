<?php

namespace App\Http\Requests\API\v1\Lead;

use App\Rules\RecaptchaLow;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LeadEmailDestinationRequest extends FormRequest
{
    /**
     * Determine if the lead_email_destination is authorized to make this request.
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
        $lead_email_destination = $this->route('lead_email_destination');

        return [
            'name' => ['bail', 'required', 'string', 'max:150', Rule::unique('lead_email_destinations')->ignore($lead_email_destination)],
            'email' => ['bail', 'required', 'email', Rule::unique('lead_email_destinations')->ignore($lead_email_destination)]
        ];
    }
}
