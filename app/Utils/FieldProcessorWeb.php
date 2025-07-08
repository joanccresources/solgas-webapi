<?php

namespace App\Utils;

class FieldProcessorWeb
{
    /**
     * Process fields for a given page section.
     *
     * @param \Illuminate\Database\Eloquent\Collection $fieldRels
     * @param array $pageContent
     * @return array
     */
    public static function processFields($fieldRels, $pageContent, $with_someone_keys = true): array
    {
        return collect($pageContent)->map(function ($value, $variablePageField) use ($fieldRels, $with_someone_keys) {
            // Busca el field relacionado con el campo actual en $pageContent
            $field = $fieldRels->firstWhere('variable', $variablePageField);

            // Procesa el valor con FieldValueProcessor
            $processedValue = FieldValueProcessor::processValue(
                $field?->typeRel->type ?? 'unknown', // Tipo de campo, usa 'unknown' si no está definido
                $value
            );

            // Construye el arreglo de datos retornado
            $data_return = [
                "name" => $field->name ?? $variablePageField, // Usa el nombre del field o la variable
                "variable_page_field" => $variablePageField,
                "type" => $field->typeRel->type ?? 'unknown', // Tipo del campo o 'unknown'
                "value" => $value ?? '', // Valor original
                'value_format' => $processedValue['value_format'],
                'value_format_2' => $processedValue['value_format_2']
            ];

            // Incluye el ID del campo si $with_someone_keys es verdadero y el campo existe
            if ($with_someone_keys && $field) {
                $data_return['id'] = $field->id;
            }

            return $data_return;
        })->toArray();
    }
}
