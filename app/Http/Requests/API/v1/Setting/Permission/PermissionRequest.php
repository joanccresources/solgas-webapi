<?php

namespace App\Http\Requests\API\v1\Setting\Permission;

use App\Models\Module;
use App\Traits\ModulesTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Permission;

class PermissionRequest extends FormRequest
{
    use ModulesTrait;

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
        $permission = $this->route('permission');

        return [
            'module_id' =>  [
                'bail',
                'required',
                'integer',
                Rule::exists('modules', 'id'),
                function ($attribute, $value, $fail) {
                    $exists =  Module::where('module_id', $value)->exists();
                    if ($exists && !$this->submodule_id) {
                        $fail('No puede registrar permisos, ya que el módulo seleccionado tiene submódulos');
                    }
                },
            ],
            'submodule_id' =>  [
                'bail',
                'nullable',
                'integer',
                Rule::exists('modules', 'id')->whereNotNull('module_id'),

            ],
            'operation_id' => [
                'required',
                'string',
                Rule::in(collect($this->operationForPermissions())->pluck('id')),
                function ($attribute, $value, $fail) use ($permission) {
                    $module = Module::where('id', $this->submodule_id ? $this->submodule_id : $this->module_id)->first();

                    // Ignorar el permiso actual al verificar la unicidad
                    $exists = Permission::where('name', $module->assigned . $value)
                        ->where('id', '!=', $permission ? $permission->id : null)
                        ->exists();

                    if ($exists) {
                        $fail('El permiso solicitado ya se encuentra registrado');
                    }
                },
            ]
        ];
    }
}
