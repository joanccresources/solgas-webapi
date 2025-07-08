<?php

namespace App\Http\Requests\API\v1\Setting\User;

use App\Enums\ModelStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules\Enum;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!auth()->user()->hasRole('Superadministrador')) {
            $roles = Role::where('guard_name', 'web')
                ->where('name',  'Superadministrador')
                ->where('id',  $this->rol_id)
                ->first();

            return !$roles;
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
        $user = $this->route('user');

        $rules = [
            'name' => 'required',
            'rol_id' =>  ['bail', 'required', 'integer', Rule::exists('roles', 'id')], //suficiente con esto, ya que se valida en el policy
            'email' => ['bail', 'required', 'email', Rule::unique('users')->ignore($user ? $user->id : '', 'id')],
            'phone' => ['nullable', 'digits:9'],
            'active' => ['required', 'boolean', new Enum(ModelStatusEnum::class)],
            'image' =>  'nullable|image|max:10000'
        ];

        switch ($this->method()) {
            case 'POST':
                $rules = array_merge($rules, ['password' => 'required|min:8']);
                break;
            case 'PUT':
                $rules = array_merge($rules, ['password' => 'nullable|min:8']);
                break;
        }

        return $rules;
    }
}
