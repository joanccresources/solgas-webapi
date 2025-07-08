<?php

namespace App\Http\Requests\API\v1\Blog;

use App\Enums\ModelStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use App\Rules\Slug;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'categories' => is_string($this->input('categories')) ? json_decode($this->input('categories'), true) :  $this->input('categories'),
            'tags' => is_string($this->input('tags')) ? json_decode($this->input('tags'), true) : $this->input('tags'),
            'similar_posts' => is_string($this->input('similar_posts')) ? json_decode($this->input('similar_posts'), true) : $this->input('similar_posts'),
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $post = $this->route('post');

        return [
            'title' => ['bail', 'required', 'string', 'max:180', Rule::unique('posts')->ignore($post)],
            'slug' => ['bail', 'required', 'string', new Slug(), 'max:180', Rule::unique('posts')->ignore($post)],
            'active' => ['required', 'boolean', new Enum(ModelStatusEnum::class)],
            'short_description' => ['required', 'string', 'max:200'],
            'content' => ['required', 'string'],
            'image' => [
                $post ? 'nullable' : 'required',
                'image',
                'max:10000',
            ],
            'thumbnail' => [
                $post ? 'nullable' : 'required',
                'image',
                'max:10000',
            ],
            'publication_at' => 'required|date_format:d-m-Y H:i:s',

            'tags' => 'nullable|array',
            'tags.*' => 'nullable|exists:tags,id',
            'categories' => 'nullable|array',
            'categories.*' => 'nullable|exists:categories,id',
            'similar_posts' => 'nullable|array',
            'similar_posts.*' => 'nullable|exists:posts,id',
        ];
    }
}
