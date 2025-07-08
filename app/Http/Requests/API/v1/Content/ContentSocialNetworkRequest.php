<?php

namespace App\Http\Requests\API\v1\Content;

use App\Enums\ModelStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;

class ContentSocialNetworkRequest extends FormRequest
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
            'url' => ['bail', 'required', 'string', 'url', 'max:2000'],
            'content_master_social_network_id' =>  [
                'bail',
                'required',
                'integer',
                Rule::exists('content_master_social_networks', 'id')
            ],
            'active' => ['required', 'boolean', new Enum(ModelStatusEnum::class)]
        ];
    }
}
