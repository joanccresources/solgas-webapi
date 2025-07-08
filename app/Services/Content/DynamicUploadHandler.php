<?php

namespace App\Services\Content;

use Illuminate\Http\Request;
use App\Actions\v1\Helpers\Storage\GenerateFileAction;
use App\Actions\v1\Helpers\Storage\GenerateOptimizedImageAction;
use App\DTOs\v1\Helpers\Storage\GenerateFileDto;

class DynamicUploadHandler
{
    const FOLDER_PRINCIPAL = 'public' . DIRECTORY_SEPARATOR;
    const FOLDER_IMAGE = 'images' . DIRECTORY_SEPARATOR . 'contenido';
    const FOLDER_VIDEO = 'videos' . DIRECTORY_SEPARATOR . 'contenido';
    const FOLDER_DOCUMENT = 'documentos' . DIRECTORY_SEPARATOR . 'contenido';

    protected $storage;

    public function __construct($storage)
    {
        $this->storage = $storage;
    }

    public function handle(Request $request, string $variable, string $type): ?string
    {
        $file = $request->file($variable);

        $imageDto = GenerateFileDto::fromArray(['file' => $file]);
        $generate = $this->generateFileActionForType($type, $imageDto->file);

        $fileName = $generate->execute(
            $imageDto->file,
            self::FOLDER_PRINCIPAL . $this->getFolderNameForType($type)
        );

        return $fileName;
    }

    protected function generateFileActionForType(string $type, $file)
    {
        // Si el tipo es 'image' pero el archivo es un SVG, usa GenerateFileAction
        if ($type === 'image' && $this->isSvg($file)) {
            return new GenerateFileAction($this->storage);
        }

        return match ($type) {
            'image' => new GenerateOptimizedImageAction($this->storage),
            default => new GenerateFileAction($this->storage),
        };
    }

    public function getFolderNameForType(string $type): string
    {
        return match ($type) {
            'image' => self::FOLDER_IMAGE,
            'video' => self::FOLDER_VIDEO,
            'document' => self::FOLDER_DOCUMENT,
            default => self::FOLDER_DOCUMENT,
        };
    }

    protected function isSvg($file): bool
    {
        // Verifica si la extensión es SVG
        if ($file->getClientOriginalExtension() === 'svg') {
            return true;
        }

        // Opcionalmente, verifica el MIME type del archivo
        if ($file->getMimeType() === 'image/svg+xml') {
            return true;
        }

        return false;
    }
}
