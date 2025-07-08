<?php

namespace App\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

trait AttributeTrait
{
    /**
     * Lista de modelos excluidos.
     */
    protected $excludedModels = [
        'Attribute',
        'AttributeOption',
        'AttributeType',
        'AttributeValue',
        'ContentMasterSocialNetwork',
        'Permission',
        'Role',
        'Module',
        'Page',
        'PageContent',
        'PageField',
        'PageFieldType',
        'PageMultipleContent',
        'PageMultipleField',
        'PageMultipleFieldData',
        'PageMultipleFieldSection',
        'PageSection',
        'CategoryPost',
        'TagPost',
        'EmploymentArea',
        'EmploymentType',
        'MasterUbigeo',
        'Comment',
    ];

    /**
     * Obtiene todos los modelos registrados en la carpeta app/Models.
     */
    public function models()
    {
        $models = [];
        $path = app_path('Models');

        if (File::exists($path)) {
            foreach (File::allFiles($path) as $file) {
                $className = $this->getClassNameFromPath($file->getPathname());
                $shortName = class_basename($className);

                // Excluir modelos que están en la lista $excludedModels
                if (in_array($shortName, $this->excludedModels)) {
                    continue;
                }

                $models[] = [
                    'id' => $className,
                    'name' => $this->humanizeModelName($className),
                ];
            }
        }

        return $models;
    }

    /**
     * Obtiene todos los modelos registrados en la carpeta app/Models,
     * incluidos modelos adicionales manualmente.
     */
    public function lookupModels()
    {
        $lookupModels = $this->models(); // Agrega los modelos dinámicamente

        return $lookupModels; // Combina ambos
    }

    /**
     * Verifica si un modelo existe en la lista de modelos registrados.
     */
    public function existModel($model)
    {
        $foundModel = collect($this->models())->first(function ($item) use ($model) {
            return $item['id'] === $model;
        });

        return !is_null($foundModel);
    }

    /**
     * Verifica si un modelo existe en la lista de lookupModels.
     */
    public function existLookupModel($model)
    {
        $foundModel = collect($this->lookupModels())->first(function ($item) use ($model) {
            return $item['id'] === $model;
        });

        return !is_null($foundModel);
    }

    /**
     * Obtiene el nombre de clase desde la ruta completa del archivo.
     */
    private function getClassNameFromPath($path)
    {
        $relativePath = str_replace(app_path(), '', $path);
        $classPath = str_replace(['/', '.php'], ['\\', ''], $relativePath);

        return 'App' . $classPath;
    }

    /**
     * Convierte el nombre del modelo en un formato legible para humanos.
     */
    private function humanizeModelName($className)
    {
        $shortName = class_basename($className);
        return ucwords(str_replace('_', ' ', Str::snake($shortName)));
    }
}
