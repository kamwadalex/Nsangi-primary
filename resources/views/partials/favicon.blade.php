@if(!empty($school['logo']))
    @php
        $logoPath = public_path('storage/'.ltrim($school['logo'], '/'));
        $isLegacyBadge = basename(parse_url($school['logo'], PHP_URL_PATH) ?: $school['logo']) === 'school-badge.jpeg';
        $logoUrl = $isLegacyBadge
            ? asset('images/school-badge.png')
            : (is_file($logoPath) ? asset('storage/'.ltrim($school['logo'], '/')) : asset('favicon.jpeg'));
        $logoType = str_ends_with(strtolower($school['logo']), '.png') || $isLegacyBadge
            ? 'image/png'
            : 'image/jpeg';
    @endphp
    <link rel="icon" href="{{ $logoUrl }}" type="{{ $logoType }}">
    <link rel="apple-touch-icon" href="{{ $logoUrl }}">
@else
    <link rel="icon" href="{{ asset('favicon.jpeg') }}" type="image/jpeg">
    <link rel="apple-touch-icon" href="{{ asset('favicon.jpeg') }}">
@endif
