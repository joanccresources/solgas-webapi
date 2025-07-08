<?php

namespace App\Actions\v1\Helpers\Storage;

use Illuminate\Support\Str;

class GenerateFileAction
{
    protected $storage;

    public function __construct($storage)
    {
        $this->storage = $storage;
    }

    public function execute($file, $folder)
    {
        // Usamos el nuevo método setFileName para obtener el nombre a guardar.
        $nameFile = $this->setFileName($folder, $file);
        $this->storage->putFileAs($folder, $file, $nameFile);

        return $nameFile;
    }

    /**
     * Genera el nombre final del archivo, conservando el nombre original,
     * y, si el archivo existe, agrega un sufijo -1, -2, etc.
     */
    public function setFileName(string $folder, $file): string
    {
        $originalName = $file->getClientOriginalName();

        $baseName   = pathinfo($originalName, PATHINFO_FILENAME);
        $extension  = pathinfo($originalName, PATHINFO_EXTENSION);

        $slugifiedName = Str::slug($baseName);

        $finalName = $slugifiedName . '.' . $extension;

        $i = 1;
        while ($this->storage->exists($folder . DIRECTORY_SEPARATOR . $finalName)) {
            $finalName = $slugifiedName . '-' . $i . '.' . $extension;
            $i++;
        }

        return $finalName;
    }
}
