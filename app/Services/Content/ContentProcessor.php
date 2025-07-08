<?php

namespace App\Services\Content;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ContentProcessor
{
    protected $uploadHandler;
    protected $storage;
    protected $model;

    public function __construct(DynamicUploadHandler $uploadHandler, $storage, string $model)
    {
        $this->uploadHandler = $uploadHandler;
        $this->storage = $storage; // Asumo que esto es una instancia de Storage, lo tipamos mejor
        $this->model = $model;
    }

    /**
     * Procesa datos de contenido, maneja subidas de archivos y devuelve un array listo para la DB.
     */
    public function processContentData(array $contentData, int $sectionId, Request $request, int $pageMultipleContentId = 0): array
    {
        $processedData = [];

        foreach ($contentData as $element) {
            $variable = $element['variable_page_field'];
            $type = $element['type'];
            $value = $element['value'];

            // Si es un archivo (imagen, video, documento), lo manejamos especial
            if (in_array($type, ['image', 'video', 'document'])) {
                $value = $this->handleFileUpload($variable, $type, $request, $sectionId, $pageMultipleContentId, $value);
            }

            // Agregamos los datos procesados al resultado
            $processedData[] = [
                'variable_page_field' => $variable,
                'value' => $value,
                'type' => $type,
                'page_section_id' => $sectionId,
            ];
        }

        return $processedData;
    }

    /**
     * Maneja la lógica de subida, reemplazo y eliminación de archivos.
     */
    private function handleFileUpload(string $variable, string $type, Request $request, int $sectionId, int $pageMultipleContentId, string $currentValue): string
    {
        // Si hay un archivo nuevo, lo subimos y reemplazamos el anterior
        if ($request->hasFile($variable)) {
            $newFileName = $this->uploadHandler->handle($request, $variable, $type);

            if ($newFileName) {
                $oldFileName = $this->getExistingFileName($variable, $sectionId, $pageMultipleContentId);
                $this->deleteFile($oldFileName, $type);
                return $newFileName;
            }
        }
        // Si no hay archivo nuevo pero el valor está vacío, eliminamos el existente
        elseif (empty($currentValue)) {
            $oldFileName = $this->getExistingFileName($variable, $sectionId, $pageMultipleContentId);
            $this->deleteFile($oldFileName, $type);
        }

        // Si no pasa nada especial, devolvemos el valor original
        return $currentValue;
    }

    /**
     * Obtiene el nombre del archivo existente en la DB según el modelo.
     */
    private function getExistingFileName(string $variable, int $sectionId, int $pageMultipleContentId): string
    {
        if ($this->model === 'PageMultipleContent' && $pageMultipleContentId) {
            $content = DB::table('page_multiple_contents')
                ->where('id', $pageMultipleContentId)
                ->value('json_value');

            return collect(json_decode($content, true))
                ->firstWhere('variable_page_field', $variable)['value'] ?? '';
        }

        return DB::table('page_contents')
            ->where('page_section_id', $sectionId)
            ->where('variable_page_field', $variable)
            ->value('value') ?? '';
    }

    /**
     * Elimina un archivo del almacenamiento si existe.
     */
    private function deleteFile(?string $fileName, string $type): void
    {
        if (!$fileName) {
            return;
        }

        $filePath = str_replace(
            '\\',
            '/',
            $this->uploadHandler::FOLDER_PRINCIPAL . $this->uploadHandler->getFolderNameForType($type) . '/' . $fileName
        );

        try {
            if ($this->storage->exists($filePath)) {
                $this->storage->delete($filePath);
            }
        } catch (\Exception $e) {
            \Log::error("Fallo al eliminar archivo '$filePath': {$e->getMessage()}");
        }
    }
}
