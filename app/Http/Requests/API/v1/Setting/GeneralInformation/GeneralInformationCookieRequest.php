<?php

namespace App\Http\Requests\API\v1\Setting\GeneralInformation;

use Illuminate\Foundation\Http\FormRequest;

class GeneralInformationCookieRequest extends FormRequest
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
            'title_cookie' => ['nullable', 'string', 'max:200'],
            'description_cookie' => ['nullable', 'string', 'max:2000'],
            'text_button_necessary_cookie' => ['nullable', 'string', 'max:200'],
            'text_button_allow_cookie' => ['nullable', 'string', 'max:200'],

            'more_information_cookie' => [
                'nullable',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt',
                'max:100000'
            ]
        ];
    }
}
