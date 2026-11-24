<?php

namespace App\Services;

use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * Upload and save a file directly into public/uploads/{folder}
     * without relying on storage:link.
     */
    public static function upload($file, string $folder): string
    {
        $targetDir = public_path('uploads/' . $folder);
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $extension = $file->getClientOriginalExtension() ?: 'jpg';
        $filename = time() . '_' . Str::random(10) . '.' . $extension;

        if (method_exists($file, 'getRealPath') && file_exists($file->getRealPath())) {
            copy($file->getRealPath(), $targetDir . DIRECTORY_SEPARATOR . $filename);
        } elseif (method_exists($file, 'move')) {
            $file->move($targetDir, $filename);
        }

        return 'uploads/' . $folder . '/' . $filename;
    }
}
