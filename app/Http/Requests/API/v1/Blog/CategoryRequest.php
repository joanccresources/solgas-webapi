<?php

namespace App\Http\Requests\API\v1\Blog;

use App\Enums\ModelStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use App\Rules\Slug;

class CategoryRequest extends FormRequest
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
        $category = $this->route('category');

        return [
            'name' => ['bail', 'required', 'string', 'max:100', Rule::unique('categories')->ignore($category)],
            'background_color' => ['required', 'string', 'max:100'],
            'point_color' => ['required', 'string', 'max:100'],
            'slug' => ['bail', 'required', 'string', new Slug(), 'max:100', Rule::unique('categories')->ignore($category)],
            'active' => ['required', 'boolean', new Enum(ModelStatusEnum::class)]
        ];
    }
}
