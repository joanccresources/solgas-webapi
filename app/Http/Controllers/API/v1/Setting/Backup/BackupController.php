<?php

namespace App\Http\Controllers\API\v1\Setting\Backup;

use App\Actions\v1\Helpers\Storage\DownloadFileAction;
use App\Http\Controllers\API\v1\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(): JsonResponse
    {
        $this->authorize('configuracion.backup.index');

        $disk = config('backup.backup.destination.disks')[0];

        $backupFolder = config('backup.backup.name');

        $files = collect(Storage::disk($disk)->files($backupFolder))
            ->map(function ($file) use ($disk, $backupFolder) {
                $timestamp = Storage::disk($disk)->lastModified($file);
                return [
                    'file_name' => basename($file),
                    'file_path' => $backupFolder . DIRECTORY_SEPARATOR . basename($file),
                    'size_mb' => round(Storage::disk($disk)->size($file) / 1024 / 1024, 2),
                    'last_modified' => date('Y-m-d H:i:s', $timestamp),
                    'timestamp' => $timestamp,
                ];
            })
            ->sortByDesc('timestamp')
            ->map(function ($file) {
                unset($file['timestamp']);
                return $file;
            })
            ->values();

        return ApiResponse::createResponse()
            ->withData($files)
            ->build();
    }

    /**
     * Download a backup file.
     */
    public function downloadBackup(Request $request)
    {
        $this->authorize('configuracion.backup.download');

        $downloadFile = new DownloadFileAction(Storage::disk(config('backup.backup.destination.disks')[0]));

        $file_ = $downloadFile->execute($request->path);

        return $file_;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
