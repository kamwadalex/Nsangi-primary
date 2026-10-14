@props([
    'src' => null,
    'label' => 'Photo',
    'variant' => 'landscape',
    'alt' => '',
])

@php
    $url = null;
    if ($src) {
        $forPdf = !empty($isPdf);
        $embedImages = $pdfEmbedImages ?? true;
        if ($forPdf && ! $embedImages) {
            $url = null;
        } elseif ($forPdf && !(str_starts_with($src, 'http://') || str_starts_with($src, 'https://'))) {
            $path = public_path('storage/'.$src);
            $url = is_file($path) ? $path : null;
        } else {
            $isRemote = str_starts_with($src, 'http://') || str_starts_with($src, 'https://');
            $storedPath = public_path('storage/'.ltrim($src, '/'));
            $url = $isRemote
                ? $src
                : (is_file($storedPath) ? asset('storage/'.ltrim($src, '/')) : asset('favicon.jpeg'));
        }
    }

    $priorityVariants = ['hero', 'badge'];
    $isPriority = in_array($variant, $priorityVariants, true);
    $dimensions = match ($variant) {
        'badge' => ['width' => 72, 'height' => 72],
        'portrait' => ['width' => 280, 'height' => 373],
        'landscape' => ['width' => 800, 'height' => 500],
        'gallery' => ['width' => 600, 'height' => 450],
        'card' => ['width' => 640, 'height' => 360],
        'banner' => ['width' => 1260, 'height' => 360],
        'hero' => ['width' => 1600, 'height' => 900],
        default => null,
    };
@endphp

@if($url)
    <img
        src="{{ $url }}"
        alt="{{ $alt ?: $label }}"
        @if($dimensions)
            width="{{ $dimensions['width'] }}"
            height="{{ $dimensions['height'] }}"
        @endif
        loading="{{ $isPriority ? 'eager' : 'lazy' }}"
        decoding="async"
        @if($isPriority) fetchpriority="high" @endif
        {{ $attributes->class(['school-image', 'school-image--'.$variant]) }}
    >
@endif
