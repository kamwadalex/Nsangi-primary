@props(['profile'])

<article class="about-profile-card">
    @if($profile->image)
        <div class="about-profile-card__photo">
            <x-school-image
                :src="$profile->image"
                variant="portrait"
                :label="$profile->name"
                :alt="$profile->name"
            />
        </div>
    @endif
    <div class="about-profile-card__body">
        <h3 class="about-profile-card__name">{{ $profile->name }}</h3>
        <p class="about-profile-card__position">{{ $profile->position }}</p>
        @if($profile->bio)
            <p class="about-profile-card__bio">{{ $profile->bio }}</p>
        @endif
    </div>
</article>
