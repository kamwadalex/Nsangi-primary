{{-- Shared public SEO tags. Override via @section('meta_description'), @section('og_image'), @section('meta_robots'), @section('canonical'). --}}
@php
    $schoolName = $school['school_name'] ?? "Nsangi Parents' Primary School";
    $pageTitle = trim($__env->yieldContent('title', $schoolName));
    $metaDescription = trim($__env->yieldContent('meta_description'));
    if ($metaDescription === '') {
        $metaDescription = $school['tagline']
            ?? $school['motto']
            ?? "{$schoolName} — mixed day and boarding primary school in Nsangi, Uganda.";
    }
    $metaDescription = \Illuminate\Support\Str::limit(preg_replace('/\s+/', ' ', $metaDescription), 160, '');

    $canonical = trim($__env->yieldContent('canonical'));
    if ($canonical === '') {
        $canonical = url()->current();
    }

    $ogImage = trim($__env->yieldContent('og_image'));
    if ($ogImage === '') {
        $ogImage = \App\Support\StoragePublicPath::url($school['hero_image'] ?? null)
            ?? \App\Support\StoragePublicPath::url($school['logo'] ?? null)
            ?? asset('favicon.jpeg');
    }

    $metaRobots = trim($__env->yieldContent('meta_robots'));
    if ($metaRobots === '') {
        $metaRobots = 'index, follow';
    }

    $sameAs = array_values(array_filter([
        $school['facebook_url'] ?? null,
        $school['twitter_url'] ?? null,
        $school['instagram_url'] ?? null,
        $school['youtube_url'] ?? null,
    ]));

    $jsonLd = [
        '@context' => 'https://schema.org',
        '@type' => 'EducationalOrganization',
        'name' => $schoolName,
        'url' => url('/'),
        'description' => $metaDescription,
        'logo' => \App\Support\StoragePublicPath::url($school['logo'] ?? null) ?? asset('favicon.jpeg'),
        'image' => $ogImage,
        'email' => $school['email'] ?? null,
        'telephone' => $school['phone'] ?? null,
        'address' => [
            '@type' => 'PostalAddress',
            'streetAddress' => $school['address'] ?? 'Nsangi Masaka Rd, P.O.Box 89',
            'addressLocality' => 'Nsangi',
            'addressRegion' => 'Wakiso',
            'addressCountry' => 'UG',
        ],
    ];

    if ($sameAs !== []) {
        $jsonLd['sameAs'] = $sameAs;
    }

    $jsonLd = array_filter($jsonLd, fn ($value) => $value !== null && $value !== '');
@endphp
<meta name="description" content="{{ $metaDescription }}">
<meta name="robots" content="{{ $metaRobots }}">
<link rel="canonical" href="{{ $canonical }}">

<meta property="og:type" content="@yield('og_type', 'website')">
<meta property="og:site_name" content="{{ $schoolName }}">
<meta property="og:title" content="{{ $pageTitle }}">
<meta property="og:description" content="{{ $metaDescription }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:locale" content="en_UG">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $pageTitle }}">
<meta name="twitter:description" content="{{ $metaDescription }}">
<meta name="twitter:image" content="{{ $ogImage }}">

<script type="application/ld+json">{!! json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP) !!}</script>
