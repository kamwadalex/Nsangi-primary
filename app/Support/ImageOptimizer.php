<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageOptimizer
{
    public static function store(
        UploadedFile $file,
        string $directory,
        int $maxWidth = 1600,
        int $quality = 82,
        string $disk = 'public'
    ): string {
        if (! extension_loaded('gd')) {
            return self::storeAndMirror($file, $directory, $disk);
        }

        $mime = strtolower((string) $file->getMimeType());
        $source = self::createImageResource($file->getRealPath(), $mime);

        if (! $source) {
            return self::storeAndMirror($file, $directory, $disk);
        }

        $width = imagesx($source);
        $height = imagesy($source);

        if ($width <= 0 || $height <= 0) {
            imagedestroy($source);

            return self::storeAndMirror($file, $directory, $disk);
        }

        $targetWidth = min($width, $maxWidth);
        $targetHeight = (int) round($height * ($targetWidth / $width));

        $canvas = imagecreatetruecolor($targetWidth, $targetHeight);

        if (in_array($mime, ['image/png', 'image/webp', 'image/gif'], true)) {
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
            $transparent = imagecolorallocatealpha($canvas, 0, 0, 0, 127);
            imagefilledrectangle($canvas, 0, 0, $targetWidth, $targetHeight, $transparent);
        }

        imagecopyresampled($canvas, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $width, $height);
        imagedestroy($source);

        $filename = self::buildFilename($directory, $mime);
        $binary = self::encodeImage($canvas, $mime, $quality);
        imagedestroy($canvas);

        if ($binary === null) {
            return self::storeAndMirror($file, $directory, $disk);
        }

        Storage::disk($disk)->put($filename, $binary);
        PublicStorageMirror::sync($filename, $disk);

        return $filename;
    }

    public static function delete(?string $path, string $disk = 'public'): void
    {
        if ($path && Storage::disk($disk)->exists($path)) {
            Storage::disk($disk)->delete($path);
        }

        if ($path && $disk === 'public') {
            $publicPath = public_path('storage/'.$path);
            if (is_file($publicPath)) {
                @unlink($publicPath);
            }
        }
    }

    private static function storeAndMirror(UploadedFile $file, string $directory, string $disk): string
    {
        $path = $file->store($directory, $disk);
        PublicStorageMirror::sync($path, $disk);

        return $path;
    }

    private static function createImageResource(string $path, string $mime): \GdImage|false|null
    {
        return match ($mime) {
            'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($path),
            'image/png' => @imagecreatefrompng($path),
            'image/webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($path) : null,
            'image/gif' => @imagecreatefromgif($path),
            default => null,
        };
    }

    private static function buildFilename(string $directory, string $mime): string
    {
        $extension = match ($mime) {
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif',
            default => 'jpg',
        };

        return trim($directory, '/').'/'.Str::uuid().'.'.$extension;
    }

    private static function encodeImage(\GdImage $canvas, string $mime, int $quality): ?string
    {
        ob_start();

        $saved = match ($mime) {
            'image/png' => imagepng($canvas, null, 6),
            'image/webp' => function_exists('imagewebp') ? imagewebp($canvas, null, $quality) : false,
            'image/gif' => imagegif($canvas),
            default => imagejpeg($canvas, null, $quality),
        };

        $contents = ob_get_clean();

        return $saved ? $contents : null;
    }
}
