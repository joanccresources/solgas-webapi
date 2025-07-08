<?php

namespace App\Http\Requests\API\v1\Content;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\ModelStatusEnum;
use Illuminate\Validation\Rules\Enum;
use App\Models\ContentHeaderMenu;

class ContentHeaderMenuRequest extends FormRequest
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
        $menuId = $this->route('content_header_menu'); // ID del menú si es update
        $parentId = $this->input('content_header_menu_id'); // ID del padre
        $menuTypeId = $this->input('content_menu_type_id');

        $rules = [
            'name' => [
                'bail',
                'required',
                'string',
                'max:200',
                function ($attribute, $value, $fail) use ($menuId, $parentId) {
                    // Buscar si hay otro menú con el mismo nombre en el mismo nivel
                    $exists = ContentHeaderMenu::where('name', $value)
                        ->where('content_header_menu_id', $parentId) // Solo dentro del mismo nivel
                        ->when($menuId, fn($query) => $query->where('id', '!=', $menuId?->id)) // Ignorar el mismo registro en update
                        ->exists();

                    if ($exists) {
                        $fail("El nombre ya existe dentro del mismo nivel jerárquico.");
                    }
                }
            ],
            'url' => ['bail', 'nullable', 'string', 'url', 'max:200'],
            'active' => ['required', new Enum(ModelStatusEnum::class)],
            'content_header_id' => ['bail', 'required', 'integer', Rule::exists('content_headers', 'id')],
            'content_header_menu_id' => [
                'bail',
                'nullable',
                'integer',
                Rule::exists('content_header_menus', 'id')->whereNot('id', $menuId?->id) // No permitir ser su propio padre
            ],
            'content_menu_type_id' => ['bail', 'required', 'integer', Rule::exists('content_menu_types', 'id')],
        ];

        switch ($menuTypeId) {
            case 1: //imagen
                $rules["content"] = ['nullable', 'image', 'max:10000'];
                break;
            case 2: //video
                $rules["content"] = ['nullable', 'file', 'mimes:mp4,mov,avi,wmv,flv,3gp,webm', 'max:200000'];
                break;
            case 3: //documento
                $rules["content"] = ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,txt', 'max:100000'];
                break;
            default:
                $rules["content"] = ['nullable', 'string', 'max:200'];
                break;
        }

        return $rules;
    }
}
