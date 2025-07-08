<?php

namespace App\Http\Requests\API\v1\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class FilterDataDashboardRequest extends FormRequest
{
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
            'end' => 'required|date_format:d-m-Y',
            'start' => 'required|date_format:d-m-Y',
        ];

        return $rules;
    }
}
