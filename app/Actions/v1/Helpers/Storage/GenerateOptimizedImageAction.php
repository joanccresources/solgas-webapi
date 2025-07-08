<?php

namespace App\Actions\v1\Helpers\Storage;

use Spatie\Image\Enums\ImageDriver;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;
use Illuminate\Support\Str;

class GenerateOptimizedImageAction
{
    protected $storage;

    public function __construct($storage)
    {
        $this->storage = $storage;
    }

    public function execute($file, $folder)
    {
        $name_file = $this->setFileName($folder, $file);

        /**
         * Procesamos el archivo para optimizarlo y convertirlo a webp
         * Nota: loadFile($file) suele funcionar si $file es una instancia de UploadedFile.
         *       A veces se requiere usar $file->path(), o guardar a una ruta temporal antes.
         */
        Image::useImageDriver(ImageDriver::Gd)
            ->loadFile($file)
            ->optimize()
            ->width(1500) //esto no altera la relacion aspecto de la imagen original, es la dimension maxima que puede tomar la imagen
            ->height(1500) //esto no altera la relacion aspecto de la imagen original, es la dimension maxima que puede tomar la imagen
            ->format('webp')
            ->save();

        $this->storage->putFileAs($folder, $file, $name_file);

        return $name_file;
    }

    /**
     * Genera el nombre final, partiendo del nombre original del usuario
     * y forzando la extensión a .webp. Si el archivo existe, aplica -1, -2, etc.
     */
    public function setFileName($folder, $file): string
    {
        $originalName = $file->getClientOriginalName();

        $baseName = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = 'webp';

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
