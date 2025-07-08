<?php

namespace App\Http\Requests\API\v1\Blog;

use App\Rules\RecaptchaHigh;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
            'name' => ['bail', 'required', 'string', 'max:150'],
            'comment' => ['bail', 'required', 'string', 'max:200'],
            'q_recaptcha' => ['required', new RecaptchaHigh()],
        ];
    }
}
