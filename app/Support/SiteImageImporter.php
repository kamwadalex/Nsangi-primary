<?php

namespace App\Support;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SiteImageImporter
{
    public static function imagesDirectory(): string
    {
        return base_path('Images');
    }

    public static function import(string $sourceFilename, string $directory, ?string $destBasename = null): ?string
    {
        $source = self::imagesDirectory().DIRECTORY_SEPARATOR.$sourceFilename;

        if (! File::exists($source)) {
            return null;
        }

        $extension = strtolower(pathinfo($source, PATHINFO_EXTENSION)) ?: 'jpg';
        $basename = $destBasename
            ? Str::slug($destBasename).'.'.$extension
            : Str::slug(pathinfo($sourceFilename, PATHINFO_FILENAME)).'.'.$extension;

        $relativePath = trim($directory, '/').'/'.$basename;
        $destination = storage_path('app/public/'.$relativePath);

        File::ensureDirectoryExists(dirname($destination));
        File::copy($source, $destination);

        // PHP's built-in server returns 403 for symlinks outside the docroot on Windows,
        // so keep a real copy under public/storage for local serving.
        $publicDestination = public_path('storage/'.$relativePath);
        File::ensureDirectoryExists(dirname($publicDestination));
        File::copy($source, $publicDestination);

        return $relativePath;
    }
}
