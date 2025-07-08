<?php

namespace App\Http\Controllers\API\v1\Helpers;

use Illuminate\Support\Facades\Storage;

use App\DTOs\v1\Helpers\Storage\DownloadFileDto;
use App\Actions\v1\Helpers\Storage\DownloadFileAction;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function downloadFile(Request $request)
    {
        $downloadFile = new DownloadFileAction(Storage::disk('s3'));

        $file_ = $downloadFile->execute($request->path);

        return $file_;
    }
}
