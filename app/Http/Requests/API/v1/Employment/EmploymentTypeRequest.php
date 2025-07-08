<?php

namespace App\Http\Requests\API\v1\Employment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmploymentTypeRequest extends FormRequest
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
        $employment_type = $this->route('employment_type');

        return [
            'name' => ['bail', 'required', 'string', 'max:150', Rule::unique('employment_types')->ignore($employment_type)],
        ];
    }
}
