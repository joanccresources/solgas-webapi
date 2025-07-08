<?php

namespace App\Http\Requests\API\v1\Employment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\ModelStatusEnum;
use Illuminate\Validation\Rules\Enum;

class EmploymentRequest extends FormRequest
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
            'title' => ['bail', 'required', 'string', 'max:200'],
            'description' => ['bail', 'required', 'string'],
            'address' => ['bail', 'required', 'string', 'max:200'],
            'employment_area_id' => ['bail', 'required', 'integer', Rule::exists('employment_areas', 'id')],
            'employment_type_id' => ['bail', 'required', 'integer', Rule::exists('employment_types', 'id')],
            'code_ubigeo' => ['bail', 'required', 'string', Rule::exists('master_ubigeo', 'code_ubigeo')],
            'active' => ['required', 'boolean', new Enum(ModelStatusEnum::class)],
            'posted_at' => 'required|date_format:d-m-Y H:i:s',

            'similar_employments' => 'nullable|array',
            'similar_employments.*' => 'nullable|exists:employments,id',
        ];
    }
}
