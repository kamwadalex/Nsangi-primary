@props(['member' => null, 'name' => 'Staff Member', 'label' => null])

@php
    $src = $member?->image;
    $alt = $member?->name ?? $name;
    $placeholderLabel = $label ?? ($member ? 'Staff Photo' : 'Photo');
@endphp

<x-school-image
    :src="$src"
    :label="$placeholderLabel"
    variant="portrait"
    :alt="$alt"
    {{ $attributes->class(['staff-photo']) }}
/>
