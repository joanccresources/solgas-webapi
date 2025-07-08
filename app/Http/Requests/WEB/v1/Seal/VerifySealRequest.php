<?php

namespace App\Http\Requests\WEB\v1\Seal;

use Illuminate\Foundation\Http\FormRequest;

class VerifySealRequest extends FormRequest
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
            'code' => 'required|string|size:6'
        ];
    }
    public function messages(): array
    {
        return [
            'code.required' => 'El código es obligatorio.',
            'code.size' => 'El código debe tener exactamente 6 caracteres.',
        ];
    }
}
