<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Admin')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="admin-login">
        <div class="admin-card">
            <h1 style="margin-top: 0; font-size: 1.25rem;">@yield('heading')</h1>
            <p style="color: var(--gray); font-size: 0.9rem;">Nsangi Parents' Primary School</p>

            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('warning'))
                <div class="alert" style="border-left: 4px solid #f59e0b;">{{ session('warning') }}</div>
            @endif

            @if($errors->any())
                <div class="alert" style="border-left: 4px solid var(--red);">
                    {{ $errors->first() }}
                </div>
            @endif

            @yield('content')

            @hasSection('footer')
                <div class="admin-auth-footer">
                    @yield('footer')
                </div>
            @endif
        </div>
    </div>
</body>
</html>
