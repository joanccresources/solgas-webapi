<?php

declare(strict_types=1);

namespace App\DTOs\v1\Helpers\Storage;

use Illuminate\Http\UploadedFile; 

class GenerateFileDto
{
    public function __construct( 
        public UploadedFile $file
    ){}
    
    public static function fromArray($array): GenerateFileDto
    {
        return new GenerateFileDto(
            file: $array['file'] 
        );
    }
}