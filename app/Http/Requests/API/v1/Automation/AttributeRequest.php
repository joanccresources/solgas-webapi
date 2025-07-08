<?php

namespace App\Http\Requests\API\v1\Automation;

use App\Enums\ModelStatusEnum;
use App\Models\AttributeType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Traits\AttributeTrait;
use Illuminate\Validation\Rules\Enum;

class AttributeRequest extends FormRequest
{
    use AttributeTrait;

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
        $attribute = $this->route('attribute');
        $attribute_type = AttributeType::where('id', $this->attribute_type_id)->first();

        return [
            'column_code' => [
                'bail',
                'required',
                'string',
                'max:150',
                function ($attribute, $value, $fail) {
                    if (!is_null($value) && !preg_match('/^[a-zA-Z_]+$/', $value)) {
                        $fail('El código de columna solo puede contener letras del alfabeto y guiones bajos en vez de espaciados.');
                    }
                },
                Rule::unique('attributes')
                    ->where(function ($query) {
                        return $query->where('model', $this->input('model'));
                    })
                    ->ignore($attribute ? $attribute->id : '', 'id')
            ],
            'name' => [
                'bail',
                'required',
                'string',
                'max:200',
                Rule::unique('attributes')
                    ->where(function ($query) {
                        return $query->where('model', $this->input('model'));
                    })
                    ->ignore($attribute ? $attribute->id : '', 'id')
            ],
            'model_lookup' =>  [
                'bail',
                $attribute_type &&  $attribute_type->type == 'lookup' ? 'required' : 'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    $exists = $this->existLookupModel($value);
                    if (!$exists) {
                        $fail('El modelo no existe');
                    }
                },
            ],
            'attribute_options' => [
                'bail',
                $attribute_type &&  $attribute_type->type == 'select' ? 'required' : 'nullable',
                'array'
            ],
            'attribute_options.*' => [
                'bail',
                $attribute_type &&  $attribute_type->type == 'select' ? 'required' : 'nullable',
            ],
            'is_required' => ['required', 'boolean'],
            'is_unique' => ['required', 'boolean'],
            'model' =>  [
                'bail',
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $exists = $this->existModel($value);
                    if (!$exists) {
                        $fail('El modelo no existe');
                    }
                },
            ],
            'active' => ['required', 'boolean', new Enum(ModelStatusEnum::class)],
            'attribute_type_id' =>  [
                'bail', 'required', 'integer', Rule::exists('attribute_types', 'id')
            ]
        ];
    }
}
