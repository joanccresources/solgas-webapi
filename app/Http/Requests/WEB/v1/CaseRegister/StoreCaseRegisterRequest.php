<?php

namespace App\Http\Requests\WEB\v1\CaseRegister;
use App\Rules\RecaptchaLow;
use Illuminate\Foundation\Http\FormRequest;

class StoreCaseRegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombres_apellidos' => 'required|string|max:100',
            'ciudad' => 'nullable|string|max:100',
            'contacto' => 'required|string|max:100',
            'nombre_negocio' => 'nullable|string|max:100',
            'razon_social' => 'nullable|string|max:100',
            'direccion_negocio' => 'nullable|string|max:150',
            'distrito' => 'nullable|string|max:100',
            'acepto_politicas' => 'required|boolean',
            'codigo_alfanumerico' => 'required|string|max:50',
            'q_recaptcha' => ['required', new RecaptchaLow()],
        ];
    }
    public function messages(): array
    {
        return [
            'nombres_apellidos.required' => 'Debe ingresar sus nombres y apellidos.',
            'nombres_apellidos.string' => 'El campo nombres y apellidos debe ser texto.',
            'nombres_apellidos.max' => 'Máximo 100 caracteres para nombres y apellidos.',

            // Si lo llena debe ser
            'ciudad.string' => 'El campo ciudad debe ser texto.',
            'ciudad.max' => 'Máximo 100 caracteres para ciudad.',

            'contacto.required' => 'Debe ingresar su correo o teléfono de contacto.',
            'contacto.string' => 'El campo contacto debe ser texto.',
            'contacto.max' => 'Máximo 100 caracteres para contacto.',

            'nombre_negocio.string' => 'El campo nombre del negocio debe ser texto.',
            'nombre_negocio.max' => 'Máximo 100 caracteres para nombre del negocio.',

            'razon_social.string' => 'El campo razón social debe ser texto.',
            'razon_social.max' => 'Máximo 100 caracteres para razón social.',

            'direccion_negocio.string' => 'El campo dirección del negocio debe ser texto.',
            'direccion_negocio.max' => 'Máximo 150 caracteres para dirección del negocio.',

            'distrito.string' => 'El campo distrito debe ser texto.',
            'distrito.max' => 'Máximo 100 caracteres para distrito.',

            'acepto_politicas.required' => 'Debe aceptar las políticas de privacidad.',
            'acepto_politicas.boolean' => 'El valor de aceptación debe ser verdadero o falso.',

            'codigo_alfanumerico.required' => 'Debe ingresar el código del balón.',
            'codigo_alfanumerico.string' => 'El código debe ser texto.',
            'codigo_alfanumerico.max' => 'Máximo 50 caracteres para el código.',

            'q_recaptcha.required' => 'Debe verificar que no es un robot.',
        ];
    }
}
