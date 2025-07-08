<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Str;

class Slug implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Convertir el valor a un slug y compararlo con el valor original
        if (Str::slug($value) !== $value) {
            $fail('El :attribute debe estar en formato slug (solo caracteres alfanuméricos, guiones y guiones bajos).');
        }
    }
}
