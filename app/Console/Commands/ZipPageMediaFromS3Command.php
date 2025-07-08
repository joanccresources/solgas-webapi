<?php

namespace App\Console\Commands;

use App\Models\GeneralInformation;
use App\Models\Page;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use ZipArchive;
use App\Models\PageField;
use App\Models\PageFieldType;
use App\Models\PageContent;
use App\Models\PageMultipleContent;

class ZipPageMediaFromS3Command extends Command
{
    /**
     * Nombre y firma del comando.
     */
    protected $signature = 'page:zip-media-s3';

    /**
     * Descripción del comando.
     */
    protected $description = 'Genera un ZIP con archivos referenciados en page_contents, page_multiple_contents, pages y general_information (image/video/document/input) leyéndolos desde S3 y subiendo el ZIP de nuevo a S3.';

    /**
     * Prefijos en S3.
     * Ajusta si tus rutas en el bucket son distintas.
     */
    const S3_PATH_IMAGE_INFORMATION = 'public/images/informacion/';
    const S3_PATH_IMAGE_PAGE        = 'public/images/pages/';
    const S3_PATH_IMAGE             = 'public/images/contenido/';
    const S3_PATH_VIDEO             = 'public/videos/contenido/';
    const S3_PATH_DOCUMENT          = 'public/documentos/contenido/';

    public function handle()
    {
        // ========================
        // 1) page_fields / page_contents
        // ========================

        // Filtra 'image', 'video', 'document'
        // (si quieres incluir 'input' en page_fields, agrégalo también)
        $targetTypes = ['image', 'video', 'document'];

        $fieldTypes = PageFieldType::whereIn('type', $targetTypes)->get();
        $typeIds    = $fieldTypes->pluck('id')->toArray();

        $pageFields = [];
        if (!empty($typeIds)) {
            $pageFields = PageField::whereIn('page_field_type_id', $typeIds)->get();
        }

        // ========================
        // 2) page_multiple_contents
        // ========================
        // Aquí buscaremos items en el JSON que sean de tipo 'image','video','document','input'
        // (o los que decidas incluir).
        $multipleContents = PageMultipleContent::all();

        // ========================
        // 3) Crear el ZIP local
        // ========================
        $zipFolder = storage_path('app/tmp');
        if (!File::exists($zipFolder)) {
            File::makeDirectory($zipFolder, 0755, true);
        }

        $zipFileName  = 'page-media-' . now()->format('Ymd_His') . '.zip';
        $zipLocalPath = $zipFolder . DIRECTORY_SEPARATOR . $zipFileName;

        $zip = new ZipArchive();
        $openResult = $zip->open($zipLocalPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);
        if ($openResult !== true) {
            $this->error("No se pudo crear el archivo ZIP en {$zipLocalPath}. Error: {$openResult}");
            return 1;
        }

        // ========================
        // 4) Agregar archivos de page_contents
        // ========================
        if ($pageFields->isNotEmpty()) {
            foreach ($pageFields as $field) {
                // Por convención: "variable_page_field" coincide con "variable" en page_fields
                $contents = PageContent::where('variable_page_field', $field->variable)->get();

                // Tipo real: "image", "video", "document"
                $typeName = optional($field->typeRel)->type;
                if (!$typeName) {
                    continue;
                }

                foreach ($contents as $content) {
                    // $content->value → nombre del archivo en S3
                    $fileName = $content->value;
                    if (!$fileName) {
                        continue;
                    }

                    // Construimos la key en S3
                    $s3Key = $this->getS3Path($typeName, $fileName);

                    // Si existe en S3, lo añadimos al ZIP
                    if (Storage::disk('s3')->exists($s3Key)) {
                        $fileContent = Storage::disk('s3')->get($s3Key);
                        // Ponemos en el ZIP con subcarpetas por tipo:
                        // p. ej. "image/<archivo>"
                        $zip->addFromString($s3Key, $fileContent);
                    }
                }
            }
        }

        // ========================
        // 5) Agregar archivos de page_multiple_contents (JSON)
        // ========================
        // En la columna "json_value" tienes un array de objetos, cada uno con
        // { "type": "image|video|document|input", "value": "archivo.svg", ... }
        // Ajusta según tu estructura real.
        foreach ($multipleContents as $mc) {
            // Decodifica el JSON
            $items = json_decode($mc->json_value, true);
            if (!is_array($items)) {
                continue;
            }

            // Recorremos cada "item" en el array
            foreach ($items as $item) {
                // Verificamos si trae "type" y "value"
                // Suponemos que "type" es uno de: 'image', 'video', 'document', 'input'
                $typeName = $item['type'] ?? null;
                $fileName = $item['value'] ?? null;

                if (!$typeName || !$fileName) {
                    // Falta info, saltamos
                    continue;
                }

                // Si queremos incluir "input" como si fuera "image",
                // o si en tu caso "input" es un archivo distinto,
                // ajusta la lógica:
                if (in_array($typeName, ['image', 'video', 'document', 'input'])) {
                    // si 'input' lo quieres manejar como "image", podemos hacer:
                    if ($typeName === 'input') {
                        $typeName = 'image';
                    }

                    // Construye la key en S3
                    $s3Key = $this->getS3Path($typeName, $fileName);

                    // Si existe en S3, descárgalo
                    if (Storage::disk('s3')->exists($s3Key)) {
                        $fileContent = Storage::disk('s3')->get($s3Key);
                        // Añadimos al ZIP
                        $zip->addFromString($s3Key, $fileContent);
                    }
                }
            }
        }

        // ========================
        // 6) Agregar archivos de pages (si tienes)
        // ========================
        // Aquí podrías agregar archivos de la tabla "pages" si los tuvieras.
        $pages = Page::all();
        foreach ($pages as $page) {
            // Ejemplo: si tienes un campo "seo_image" en la tabla "pages"
            $pageImage = $page->seo_image;
            if ($pageImage) {
                $s3Key = self::S3_PATH_IMAGE_PAGE . $pageImage;
                if (Storage::disk('s3')->exists($s3Key)) {
                    $fileContent = Storage::disk('s3')->get($s3Key);
                    $zip->addFromString($s3Key, $fileContent);
                }
            }
        }

        // ========================
        // 7) Agregar archivos de la tabla "general_information"
        // ========================
        $general_information = GeneralInformation::first();
        $logos_general_information = [
            $general_information->logo_principal ?? null,
            $general_information->logo_footer ?? null,
            $general_information->logo_icon ?? null,
            $general_information->logo_email ?? null,
        ];

        foreach ($logos_general_information as $logo) {
            if ($logo) {
                $s3Key = self::S3_PATH_IMAGE_INFORMATION . $logo;
                if (Storage::disk('s3')->exists($s3Key)) {
                    $fileContent = Storage::disk('s3')->get($s3Key);
                    $zip->addFromString($s3Key, $fileContent);
                }
            }
        }

        // ========================
        // Cerramos el ZIP
        $zip->close();

        // ========================
        // 8) Subir el ZIP a S3
        // ========================
        $s3ZipKey = 'zips/' . $zipFileName;
        Storage::disk('s3')->put($s3ZipKey, File::get($zipLocalPath));

        // (Opcional) Eliminar el ZIP local
        File::delete($zipLocalPath);

        $this->info("ZIP generado en {$zipLocalPath} y subido a S3: {$s3ZipKey}");

        return 0;
    }

    /**
     * Retorna la ruta (key) en S3 según el tipo (image, video, document).
     * Para 'input', lo tratamos como 'image' en el bloque anterior.
     */
    private function getS3Path($typeName, $fileName)
    {
        switch ($typeName) {
            case 'image':
                return self::S3_PATH_IMAGE . $fileName;
            case 'video':
                return self::S3_PATH_VIDEO . $fileName;
            case 'document':
                return self::S3_PATH_DOCUMENT . $fileName;
            default:
                // Para otros tipos (o si ajustas 'input' aquí),
                // podría retornar la misma ruta de 'image' o algo genérico.
                return self::S3_PATH_IMAGE . $fileName;
        }
    }
}
