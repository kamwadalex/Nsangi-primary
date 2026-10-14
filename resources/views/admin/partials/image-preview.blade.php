{{--
  Current image preview for admin edit forms.
  Props: current (storage path or null), input (file input id), alt, maxHeight
--}}
@props([
    'current' => null,
    'input',
    'alt' => 'Current image',
    'maxHeight' => 120,
])

@php
    $currentUrl = $current
        ? (str_starts_with($current, 'http://') || str_starts_with($current, 'https://')
            ? $current
            : asset('storage/'.$current))
        : null;
@endphp

<div class="admin-image-preview" data-image-preview data-input-id="{{ $input }}">
    <p class="admin-image-preview__label" @if(!$currentUrl) hidden @endif>Current image</p>
    <p class="admin-image-preview__frame" @if(!$currentUrl) hidden @endif>
        <img
            @if($currentUrl) src="{{ $currentUrl }}" @endif
            alt="{{ $alt }}"
            class="admin-image-preview__img"
            style="max-height: {{ (int) $maxHeight }}px;"
            data-preview-img
            @if(!$currentUrl) hidden @endif
        >
    </p>
    <p class="admin-image-preview__empty" @if($currentUrl) hidden @endif data-preview-empty>
        No image uploaded yet.
    </p>
    <p class="admin-image-preview__hint" hidden data-preview-pending>New image selected — save to keep this change.</p>
</div>
