<?php

namespace App\Actions\v1\Helpers\Storage;

class DownloadFileAction
{
    protected $storage;

    public function __construct($storage)
    {
        $this->storage = $storage;
    }

    /**
     * @return null|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function execute($path)
    {
        if ($this->storage->exists($path)) {
            return $this->storage->download($path);
        }

        return null;
    }
}
