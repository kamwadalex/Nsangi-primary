<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PublicStorageMirror
{
    /**
     * Keep a real copy under public/storage so PHP's built-in server
     * can serve uploads on Windows without symlink 403s.
     */
    public static function sync(?string $relativePath, string $disk = 'public'): void
    {
        if (! $relativePath || $disk !== 'public') {
            return;
        }

        $source = Storage::disk($disk)->path($relativePath);

        if (! is_file($source)) {
            return;
        }

        $destination = public_path('storage/'.$relativePath);
        File::ensureDirectoryExists(dirname($destination));
        File::copy($source, $destination);
    }
}
