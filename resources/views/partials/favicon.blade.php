@if(!empty($school['logo']))
    @php
        $logoPath = public_path('storage/'.ltrim($school['logo'], '/'));
        $logoUrl = is_file($logoPath) ? asset('storage/'.ltrim($school['logo'], '/')) : asset('favicon.jpeg');
    @endphp
    <link rel="icon" href="{{ $logoUrl }}" type="image/jpeg">
    <link rel="apple-touch-icon" href="{{ $logoUrl }}">
@else
    <link rel="icon" href="{{ asset('favicon.jpeg') }}" type="image/jpeg">
    <link rel="apple-touch-icon" href="{{ asset('favicon.jpeg') }}">
@endif
