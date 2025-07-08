<?php

namespace App\Http\Requests\API\v1\Setting\Module;

use App\Enums\ModelStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class ModuleRequest extends FormRequest
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
        $module = $this->route('module');

        return [
            'name' => ['bail', 'required', 'string', 'max:200', Rule::unique('modules')->whereNull('module_id')->ignore($module ? $module->id : '', 'id')],
            'singular_name' => ['bail', 'required', 'string', 'max:200'],
            'icon' => ['bail', 'required', 'string', 'max:100'],
            'per_page' => ['bail', $this->is_crud ? 'required' : 'nullable', 'integer', $this->is_crud ? 'min:1' : ''],
            'page' => ['bail',  $this->is_crud ? 'required' : 'nullable', 'integer', $this->is_crud ? 'min:1' : ''],
            'sort_by' => ['bail',  $this->is_crud ? 'required' : 'nullable', 'string', 'max:100'],
            'order_direction' => ['bail',  $this->is_crud ? 'required' : 'nullable', 'string', 'max:50', Rule::in(['ASC', 'DESC'])],
            'is_crud' => ['required', 'boolean'],
            'show_in_sidebar' => ['required', 'boolean'],
            'active' => ['required', 'boolean', new Enum(ModelStatusEnum::class)]
        ];
    }
}
