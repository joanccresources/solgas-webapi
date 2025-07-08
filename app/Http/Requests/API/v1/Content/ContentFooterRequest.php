<?php

namespace App\Http\Requests\API\v1\Content;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\ModelStatusEnum;
use Illuminate\Validation\Rules\Enum;

class ContentFooterRequest extends FormRequest
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
        $content_footer = $this->route('content_footer');

        return [
            'name' => ['bail', 'required', 'string', 'max:200', Rule::unique('content_footers')->ignore($content_footer)],
            'active' => ['required', 'boolean', new Enum(ModelStatusEnum::class)]
        ];
    }
}
