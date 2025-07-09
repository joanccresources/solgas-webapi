<?php

namespace App\Http\Requests\WEB\v1\Client;
use App\Rules\RecaptchaLow;
use Illuminate\Foundation\Http\FormRequest;

class RegisterClientRequest extends FormRequest
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
            'nombres_apellidos' => 'required|string|max:255',
            'documento_identidad' => 'required|numeric|unique:sqlsrv_cilindros.Clientes,documento_identidad',
            'telefono' => 'required|numeric',
            'correo_electronico' => 'nullable|email|max:255',
            'direccion' => 'nullable|string|max:255',
            'ciudad' => 'required|string|max:255',
            'acepto_politicas' => 'required|boolean',
            'q_recaptcha' => ['required', new RecaptchaLow()],
        ];
    }

    public function messages(): array
    {
        return [
            'nombres_apellidos.required' => 'El nombre y apellido es obligatorio.',
            'documento_identidad.required' => 'El documento de identidad es obligatorio.',
            'documento_identidad.numeric' => 'El documento de identidad debe ser numérico.',
            'documento_identidad.unique' => 'Ya existe un cliente registrado con este documento de identidad.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'telefono.numeric' => 'El teléfono debe ser numérico.',
            'correo_electronico.email' => 'El correo electrónico no tiene un formato válido.',
            'ciudad.required' => 'La ciudad es obligatoria.',
            'acepto_politicas.required' => 'Debe aceptar las políticas.',
            'acepto_politicas.boolean' => 'El campo de aceptación de políticas debe ser verdadero o falso.',
        ];
    }

}
