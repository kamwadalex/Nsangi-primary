<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <meta name="admin-notifications-url" content="{{ route('admin.notifications.unread') }}">
    <meta name="admin-notifications-initial" content="{{ json_encode($adminUnreadCounts ?? ['messages' => 0, 'admissions' => 0, 'total' => 0]) }}">
    <title>@yield('title', 'Admin') — {{ $school['school_name'] ?? "Nsangi Parents' Primary School" }}</title>
    @include('partials.favicon')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ @filemtime(public_path('css/app.css')) ?: '1' }}">
</head>
<body class="admin-body">
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="admin-sidebar__brand">
                <x-school-image
                    :src="$school['logo'] ?? null"
                    variant="badge"
                    label="School Badge"
                    alt="{{ $school['school_name'] ?? 'School logo' }}"
                />
                <h2>Admin Panel</h2>
            </div>
            <nav>
                <a href="{{ route('admin.dashboard') }}" @if(request()->routeIs('admin.dashboard')) class="active" @endif>Dashboard</a>
                <a href="{{ route('admin.help') }}" @if(request()->routeIs('admin.help')) class="active" @endif>How-To Guide</a>
                <a href="{{ route('admin.settings.edit') }}" @if(request()->routeIs('admin.settings.*')) class="active" @endif>Settings</a>
                <a href="{{ route('admin.updates.index') }}" @if(request()->routeIs('admin.updates.*') || request()->routeIs('admin.posts.*') || request()->routeIs('admin.events.*') || request()->routeIs('admin.gallery.*')) class="active" @endif>Updates</a>
                <a href="{{ route('admin.pages.index') }}" @if(request()->routeIs('admin.pages.*')) class="active" @endif>Pages</a>
                <a href="{{ route('admin.staff.index') }}" @if(request()->routeIs('admin.staff.*')) class="active" @endif>Staff</a>
                <a href="{{ route('admin.about-profiles.index') }}" @if(request()->routeIs('admin.about-profiles.*')) class="active" @endif>About Profiles</a>
                <a href="{{ route('admin.school-fees.index') }}" @if(request()->routeIs('admin.school-fees.*')) class="active" @endif>School Fees</a>
                <a href="{{ route('admin.sensitive-documents.index') }}" @if(request()->routeIs('admin.sensitive-documents.*') || request()->routeIs('admin.sensitive-sections.*')) class="active" @endif>Sensitive Information</a>
                <a href="{{ route('admin.messages.index') }}" class="admin-nav-link--with-badge @if(request()->routeIs('admin.messages.*')) active @endif">
                    <span>Messages</span>
                    <span class="admin-nav-badge" data-notification-badge="messages" @if(($adminUnreadCounts['messages'] ?? 0) === 0) hidden @endif aria-label="Unread messages">{{ ($adminUnreadCounts['messages'] ?? 0) > 99 ? '99+' : ($adminUnreadCounts['messages'] ?? 0) }}</span>
                </a>
                <a href="{{ route('home') }}" target="_blank">View Site</a>
                <form action="{{ route('admin.logout') }}" method="POST" style="margin-top: 1rem; padding: 0 1.25rem;">
                    @csrf
                    <button type="submit" class="btn btn-outline" style="width: 100%;">Logout</button>
                </form>
            </nav>
        </aside>
        <main class="admin-main">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="alert" style="border-left: 4px solid var(--red);">{{ $errors->first() }}</div>
            @endif
            @yield('content')
        </main>
    </div>
    <script src="{{ asset('js/admin-notifications.js') }}" defer></script>
    <script src="{{ asset('js/admin-image-preview.js') }}" defer></script>
</body>
</html>
