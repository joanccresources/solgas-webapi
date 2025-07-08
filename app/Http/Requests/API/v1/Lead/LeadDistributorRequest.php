<?php

namespace App\Http\Requests\API\v1\Lead;

use App\Rules\RecaptchaLow;
use Illuminate\Foundation\Http\FormRequest;

class LeadDistributorRequest extends FormRequest
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
            'full_name' => ['bail', 'required', 'string', 'max:255'], // Obligatorio, máximo 255 caracteres
            'dni_or_ruc' => ['bail', 'required', 'string', 'regex:/^\d{8,11}$/'], // Obligatorio, debe ser un DNI (8 dígitos) o RUC (11 dígitos)
            'phone_1' => ['bail', 'required', 'string', 'max:15', 'regex:/^[0-9+()\-\s]*$/'], // Obligatorio, formato válido de teléfono
            'phone_2' => ['bail', 'nullable', 'string', 'max:15', 'regex:/^[0-9+()\-\s]*$/'], // Opcional, formato válido de teléfono
            'email' => ['bail', 'required', 'email:rfc,dns', 'max:255'], // Obligatorio, debe ser un email válido
            'address' => ['bail', 'required', 'string', 'max:255'], // Obligatorio, máximo 255 caracteres
            'code_ubigeo' => ['bail', 'required', 'string', 'size:6', 'exists:master_ubigeo,code_ubigeo'], // Obligatorio, debe existir en la tabla master_ubigeo
            'has_store' => ['bail', 'required', 'boolean'], // Obligatorio, debe ser booleano (true/false)
            'sells_gas_cylinders' => ['bail', 'required', 'boolean'], // Obligatorio, debe ser booleano (true/false)
            'brands_sold' => ['bail', 'required', 'string', 'max:255'], // Opcional, máximo 255 caracteres
            'selling_time' => ['bail', 'required', 'string', 'max:255'], // Opcional, máximo 255 caracteres
            'monthly_sales' => ['bail', 'required', 'integer', 'min:0'], // Opcional, debe ser un entero positivo o cero
            'accepts_data_policy' => ['bail', 'required', 'boolean'], // Obligatorio, debe ser booleano (true/false)
            'q_recaptcha' => ['required', new RecaptchaLow()],
        ];
    }
}
