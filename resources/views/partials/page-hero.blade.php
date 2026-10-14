@props(['title', 'subtitle' => null, 'banner' => null])

<section class="page-hero page-hero--banner">
    <div class="page-hero__media">
        <x-school-image
            :src="$banner ?? ($school['page_banner'] ?? null)"
            variant="hero"
            :label="$title"
            :alt="$title"
        />
    </div>
    <div class="page-hero__overlay" aria-hidden="true"></div>
    <div class="page-hero__content container">
        @if($subtitle)
            <p class="page-hero__subtitle">{{ $subtitle }}</p>
        @endif
        <h1>{{ $title }}</h1>
    </div>
</section>
