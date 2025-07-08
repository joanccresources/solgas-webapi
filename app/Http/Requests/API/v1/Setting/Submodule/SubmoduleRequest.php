<?php

namespace App\Http\Requests\API\v1\Setting\Submodule;

use App\Enums\ModelStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class SubmoduleRequest extends FormRequest
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
        $submodule = $this->route('submodule');

        return [
            'name' => ['bail', 'required', 'string', 'max:200', Rule::unique('modules')->where(function ($query) {
                return $query->where('module_id', $this->input('module_id'));
            })->ignore($submodule ? $submodule->id : '', 'id')],
            'singular_name' => ['bail', 'required', 'string', 'max:200'],
            'per_page' => ['bail', $this->is_crud ? 'required' : 'nullable', 'integer', $this->is_crud ? 'min:1' : ''],
            'page' => ['bail',  $this->is_crud ? 'required' : 'nullable', 'integer', $this->is_crud ? 'min:1' : ''],
            'sort_by' => ['bail',  $this->is_crud ? 'required' : 'nullable', 'string', 'max:100'],
            'order_direction' => ['bail',  $this->is_crud ? 'required' : 'nullable', 'string', 'max:50', Rule::in(['ASC', 'DESC'])],
            'is_crud' => ['required', 'boolean'],
            'show_in_sidebar' => ['required', 'boolean'],
            'active' => ['required', 'boolean', new Enum(ModelStatusEnum::class)],
            'module_id' =>  ['bail', 'required', 'integer', Rule::exists('modules', 'id')->whereNull('module_id')]
        ];
    }
}
