<?php

namespace App\Support;

final class StoragePublicPath
{
    public static function url(?string $path, bool $forPdf = false): ?string
    {
        if (! $path) {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        $relative = ltrim($path, '/');
        if (str_starts_with($relative, 'storage/')) {
            $relative = substr($relative, strlen('storage/'));
        }

        if ($forPdf) {
            $absolute = public_path('storage/'.$relative);

            return is_file($absolute) ? $absolute : null;
        }

        return asset('storage/'.$relative);
    }
}
