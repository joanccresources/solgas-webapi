<?php

namespace App\Utils;

class FieldValueProcessor
{
    // Folder path for images
    private const FOLDER_IMAGE = DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'contenido' . DIRECTORY_SEPARATOR;

    // Folder path for videos
    private const FOLDER_VIDEO = DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'videos' . DIRECTORY_SEPARATOR . 'contenido' . DIRECTORY_SEPARATOR;

    // Folder path for videos
    private const FOLDER_DOCUMENT = DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'documentos' . DIRECTORY_SEPARATOR . 'contenido' . DIRECTORY_SEPARATOR;

    /**
     * Process the field value based on its type.
     *
     * @param string $type The type of the field (e.g., 'image', 'video', etc.).
     * @param string|null $value The actual value of the field.
     * @return string The processed value with the correct folder path or the original value if not applicable.
     */
    public static function processValue(string $type, ?string $value): array
    {
        // If the type is 'image' and a value exists, return the value with the image folder path
        if ($type === 'image' && $value) {
            return [
                'value_format' => config('services.s3_bucket.url_bucket_public') . self::FOLDER_IMAGE . $value,
                'value_format_2' => $value,
            ];
        }

        // If the type is 'video' and a value exists, return the value with the video folder path
        if ($type === 'video' && $value) {
            return [
                'value_format' => config('services.s3_bucket.url_bucket_public') . self::FOLDER_VIDEO . $value,
                'value_format_2' => $value,
            ];
        }

        // If the type is 'document' and a value exists, return the value with the document folder path
        if ($type === 'document' && $value) {
            return [
                'value_format' => config('services.s3_bucket.url_bucket_public') . self::FOLDER_DOCUMENT . $value,
                'value_format_2' => $value,
            ];
        }

        // Return the original value or an empty string if no value exists
        return [
            'value_format' => $value ?? '',
            'value_format_2' => $value ?? '',
        ];
    }
}
