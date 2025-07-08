<?php

declare(strict_types=1);

namespace App\DTOs\v1\Helpers\Storage; 

class DownloadFileDto
{
    public function __construct(
        public string $folder, 
        public string $subfolder,
        public string $file
    ){}
    
    public static function fromArray($array): DownloadFileDto
    {
        return new DownloadFileDto(
            folder: $array['folder'],
            subfolder: $array['subfolder'],
            file: $array['file']
        );
    }
}