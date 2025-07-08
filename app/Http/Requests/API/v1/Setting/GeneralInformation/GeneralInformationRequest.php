<?php

namespace App\Http\Requests\API\v1\Setting\GeneralInformation;

use Illuminate\Foundation\Http\FormRequest;

class GeneralInformationRequest extends FormRequest
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
            'phone' => ['required', 'string', 'max:100'],
            'whatsapp' => ['required', 'string', 'max:100'],
            'logo_principal' => [
                'nullable',
                'file', // Cambiado a file para soportar más tipos de archivo
                'mimetypes:image/jpeg,image/jpg,image/webp,image/png,image/svg+xml', // Solo permite JPG, PNG y SVG
                'max:10000', // Máximo 5 MB
            ],
            'logo_footer' => [
                'nullable',
                'file', // Cambiado a file para soportar más tipos de archivo
                'mimetypes:image/jpeg,image/jpg,image/webp,image/png,image/svg+xml', // Solo permite JPG, PNG y SVG
                'max:10000', // Máximo 5 MB
            ],
            'logo_icon' => [
                'nullable',
                'file', // Cambiado a file
                'mimetypes:image/x-icon,image/vnd.microsoft.icon', // Solo permite archivos .ico
                'max:10000', // Máximo 5 MB
            ],
            'logo_email' => [
                'nullable',
                'image', // Solo imágenes optimizables
                'mimetypes:image/jpeg,image/jpg,image/webp,image/png', // Permite JPG y PNG únicamente
                'max:10000', // Máximo 5 MB
            ],
        ];
    }
}
