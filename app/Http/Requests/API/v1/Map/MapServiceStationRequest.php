<?php

namespace App\Http\Requests\API\v1\Map;

use App\Enums\ModelStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;


class MapServiceStationRequest extends FormRequest
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
            'name' => ['bail', 'required', 'string', 'max:200'],
            'address' => ['bail', 'required', 'string', 'max:200'],
            'schedule' => ['bail', 'nullable', 'string', 'max:200'],
            'phone' => ['bail', 'nullable', 'string', 'max:200'],
            'latitude' => ['bail', 'nullable', 'numeric'],
            'longitude' => ['bail', 'nullable', 'numeric'],
            'code_department' => ['bail', 'nullable', 'string', 'max:2', 'exists:master_ubigeo,code_department'],
            'code_province' => ['bail', 'nullable', 'string', 'max:2', 'exists:master_ubigeo,code_province'],
            'code_district' => ['bail', 'nullable', 'string', 'max:2', 'exists:master_ubigeo,code_district'],
            'active' => ['required', 'boolean', new Enum(ModelStatusEnum::class)],
            'type_map_id' => ['required', 'integer', 'exists:type_maps,id', 'not_in:4'],
        ];
    }
}
