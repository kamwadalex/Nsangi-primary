@props(['member'])

@php
    $nameParts = preg_split('/\s+/', trim($member->name));
    $lastName = count($nameParts) > 1 ? array_pop($nameParts) : '';
    $firstName = implode(' ', $nameParts) ?: $member->name;
@endphp

<article class="staff-member-card">
    @if($member->image)
        <div class="staff-member-card__photo">
            <x-school-image :src="$member->image" variant="portrait" :label="$member->name" :alt="$member->name" />
        </div>
    @endif
    <div class="staff-member-card__body">
        <div class="staff-member-card__names">
            <span class="staff-member-card__fname">{{ $firstName }}</span>
            @if($lastName)
                <span class="staff-member-card__lname">{{ $lastName }}</span>
            @endif
        </div>
        <div class="staff-member-card__job">{{ $member->position }}</div>
        <div class="staff-member-card__desc">
            @if($member->bio)
                <p>{{ $member->bio }}</p>
            @endif
        </div>
    </div>
</article>
