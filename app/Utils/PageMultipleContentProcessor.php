<?php

namespace App\Utils;

class PageMultipleContentProcessor
{
    /**
     * Procesar el formato de json_value_format para un PageMultipleContent
     *
     * @param  mixed  $pageMultipleContent
     * @return mixed
     */
    public static function process($pageMultipleContent, $is_for_web = false)
    {
        // Decodificar el JSON de json_value
        $jsonValue = json_decode($pageMultipleContent->json_value, true);

        // Crear un mapa de valores basado en la clave 'variable_page_field'
        $valueMap = collect($jsonValue)->keyBy('variable_page_field');


        if ($is_for_web) {
            // Generar el nuevo formato de json_value_format basado en valueMap
            $newJsonValueFormat = $valueMap->mapWithKeys(function ($value, $variable) use ($pageMultipleContent) {
                // Encuentra el campo relacionado en dataRels usando la variable
                $dataRel = $pageMultipleContent->multipleFieldRel->dataRels->firstWhere('variable', $variable);

                // Procesa el valor utilizando FieldValueProcessor
                $processedValue = FieldValueProcessor::processValue(
                    $dataRel?->typeRel->type ?? 'unknown', // Usa 'unknown' si el tipo no está definido
                    $value['value'] ?? null
                );

                // Devuelve el formato esperado como clave-valor
                return [
                    $variable => [
                        'name' => $dataRel->name ?? $variable, // Usa el nombre de dataRel o la variable
                        'variable_page_field' => $variable,
                        'type' => $dataRel->typeRel->type ?? 'unknown', // Tipo del campo o 'unknown'
                        'value' => $value['value'] ?? '', // Valor original
                        'value_format' => $processedValue['value_format'], // Valor procesado
                        'value_format_2' => $processedValue['value_format_2'],
                    ],
                ];
            });
        } else {
            // Generar el nuevo formato de json_value_format
            $newJsonValueFormat = $pageMultipleContent->multipleFieldRel->dataRels
                ->sortBy('index')
                ->values()
                ->map(function ($dataRel) use ($valueMap) {
                    $variable = $dataRel->variable;

                    $value = FieldValueProcessor::processValue(
                        $dataRel->typeRel->type,
                        $valueMap->get($variable)['value'] ?? null
                    );

                    return [
                        'name' => $dataRel->name,
                        'variable_page_field' => $variable,
                        'type' => $dataRel->typeRel->type,
                        'value' => $valueMap->get($variable)['value'] ?? '',
                        'value_format' => $value['value_format'],
                        'value_format_2' => $value['value_format_2']
                    ];
                });
        }

        // Agregar el nuevo formato al elemento
        $pageMultipleContent->json_value_format2 = $newJsonValueFormat;

        return $pageMultipleContent;
    }
}
