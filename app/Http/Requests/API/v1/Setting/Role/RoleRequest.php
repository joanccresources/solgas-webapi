<?php

namespace App\Http\Requests\API\v1\Setting\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $role = $this->route('role');
        if ($role && $role->id == 1) {
            // no se puede editar un rol de tipo Superadministrador, 
            // no se puede colocar en el policy porque cuando es de tipo Superadministrador tiene permiso de hacer todo.
            return false;
        }
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $role = $this->route('role');

        $rules = [
            'name' => ['bail', 'required', 'max:100', Rule::unique('roles')->ignore($role ? $role->id : '', 'id')],
            'permissions' => 'required|array',
        ];

        if (is_array($this->permissions)) {
            foreach ($this->permissions as $key => $val) {
                $rules = array_merge($rules, ['permissions.' . $key =>  [
                    'bail', 'integer', Rule::exists('permissions', 'id')
                ]]);
            }
            $rules = array_merge($rules, ['permissions.*' => 'distinct']);
        }

        return $rules;
    }
}
