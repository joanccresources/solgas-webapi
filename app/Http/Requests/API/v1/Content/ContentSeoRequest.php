<?php

namespace App\Http\Requests\API\v1\Content;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Rules\Slug;

class ContentSeoRequest extends FormRequest
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
        $content_seo = $this->route('content_seo');

        return [
            'name' => ['bail', 'required', 'string', 'max:60', Rule::unique('pages')->ignore($content_seo)],
            'seo_image' => 'nullable|image|max:10000',
            'seo_keywords' => 'required|string|max:100',
            'seo_description' => 'required|string|max:160',
        ];
    }
}
