<?php

namespace App\Http\Requests\API\v1\Content;

use App\Enums\ModelStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SustainabilityReportRequest extends FormRequest
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
        $sustainability_report = $this->route('sustainability_report');

        return [
            'title' => ['bail', 'required', 'string', 'max:180'],
            'active' => ['required', 'boolean', new Enum(ModelStatusEnum::class)],
            'title_milestones' => ['nullable', 'string', 'max:200'],
            'pdf' => [
                $sustainability_report ? 'nullable' : 'required',
                'file',
                'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt',
                'max:100000'
            ],
        ];
    }
}
