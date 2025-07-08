<?php

namespace App\Http\Requests\API\v1\Content;

use App\Enums\ModelStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class SustainabilityReportObjectRequest extends FormRequest
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
        $sustainability_report_object = $this->route('sustainability_report_object');

        return [
            'active' => ['required', 'boolean', new Enum(ModelStatusEnum::class)],
            'sustainability_report_id' => 'required|integer|exists:sustainability_reports,id',
            'image' => [
                $sustainability_report_object ? 'nullable' : 'required',
                'image',
                'max:10000'
            ],
        ];
    }
}
