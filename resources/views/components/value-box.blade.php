@props(['title', 'icon', 'color' => 'green'])

<div class="value-box">
    <div class="value-box__icon value-box__icon--{{ $color }}" aria-hidden="true">
        <x-icons :name="$icon" />
    </div>
    <h3>{{ $title }}</h3>
    <p>{{ $slot }}</p>
</div>
