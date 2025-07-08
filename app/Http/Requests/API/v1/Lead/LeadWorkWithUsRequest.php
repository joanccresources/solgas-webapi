<?php

namespace App\Http\Requests\API\v1\Lead;

use App\Rules\RecaptchaLow;
use Illuminate\Foundation\Http\FormRequest;

class LeadWorkWithUsRequest extends FormRequest
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
            'cv_path' => ['bail', 'required', 'file', 'mimes:pdf', 'max:10000'], // Archivo obligatorio, tipo PDF, máximo 5MB
            'full_name' => ['bail', 'required', 'string', 'max:255'], // Nombre completo, obligatorio y máximo 255 caracteres
            'dni' => ['bail', 'required', 'string', 'size:8', 'regex:/^[0-9]+$/'], // DNI de 8 caracteres, solo números
            'phone' => ['bail', 'required', 'string', 'max:15', 'regex:/^[0-9+()\-\s]*$/'], // Teléfono, máximo 15 caracteres, permite números y símbolos comunes
            'address' => ['bail', 'required', 'string', 'max:255'], // Dirección, obligatoria y máximo 255 caracteres
            'email' => ['bail', 'required', 'email:rfc,dns', 'max:255'], // Email válido según RFC
            'birth_date' => ['bail', 'required', 'date_format:d-m-Y', 'before:today'], // Fecha de nacimiento, obligatoria y debe ser anterior a hoy
            'employment_id' => ['bail', 'required', 'integer', 'exists:employments,id'], // ID del empleo, obligatorio y debe existir en la tabla `employments`
            'q_recaptcha' => ['required', new RecaptchaLow()],
        ];
    }
}
