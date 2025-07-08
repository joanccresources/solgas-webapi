<?php

namespace App\Http\Requests\API\v1\Helpers\Order;

use App\Traits\AttributeTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ContentOrderRequest extends FormRequest
{
    use AttributeTrait;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'items' => 'required|array',
            'items.*.id' =>  [
                'bail',
                'required',
                'integer'
            ],
            /* 'model' =>  [
                'bail',
                'required',
                'string',
                function ($attribute, $value, $fail) {
                    $exists = $this->existModel($value);
                    if (!$exists) {
                        $fail('El modelo no existe');
                    }
                },
            ], */
        ];

        return $rules;
    }
}
