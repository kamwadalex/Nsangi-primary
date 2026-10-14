@props(['label', 'value' => null, 'full' => false, 'multiline' => false])

<div class="print-form__field @if($full) print-form__field--full @endif @if($multiline) print-form__field--multiline @endif">
    <span class="print-form__label">{{ $label }}</span>
    <span class="print-form__value">{!! nl2br(e($value ?? '')) !!}</span>
</div>
