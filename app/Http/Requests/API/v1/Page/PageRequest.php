<?php

namespace App\Http\Requests\API\v1\Page;

use App\Enums\ModelStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use App\Rules\Slug;

class PageRequest extends FormRequest
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
        $page = $this->route('page');

        return [
            'name' => ['bail', 'required', 'string', 'max:60', Rule::unique('pages')->ignore($page ? $page->id : '', 'id')],
            'slug' => ['bail', 'required', 'string', new Slug(), 'max:60', Rule::unique('pages')->ignore($page ? $page->id : '', 'id')],
            'active' => ['required', 'boolean', new Enum(ModelStatusEnum::class)]
        ];
    }
}
