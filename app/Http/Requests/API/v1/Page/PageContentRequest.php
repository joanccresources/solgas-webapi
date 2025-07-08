<?php

namespace App\Http\Requests\API\v1\Page;

use Illuminate\Foundation\Http\FormRequest;

class PageContentRequest extends FormRequest
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
            'content' => is_string($this->input('content')) ? json_decode($this->input('content'), true) : $this->input('content'),
        ]);
    }

    public function rules(): array
    {
        $rules = [
            'content' => 'required|array',
        ];

        $contentData = $this->input('content');

        if (is_array($contentData)) {
            foreach ($contentData as $data) {
                $variable = $data['variable_page_field'] ?? null;
                if ($variable && $data['type'] === 'image') {
                    $rules[$variable] = 'nullable|image|max:10000';
                }
                if ($variable && $data['type'] === 'video') {
                    $rules[$variable] = 'nullable|file|mimes:mp4,mov,avi,wmv,flv,3gp,webm|max:200000';
                }
                if ($variable && $data['type'] === 'document') {
                    $rules[$variable] = 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt|max:100000';
                }
            }
        }

        return $rules;
    }
}
