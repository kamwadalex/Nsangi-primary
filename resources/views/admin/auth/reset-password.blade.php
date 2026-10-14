@extends('admin.auth.partials.card')

@section('title', 'New Password')
@section('heading', 'Choose a New Password')

@section('content')
<p style="color: var(--gray); font-size: 0.9rem; margin-top: 0;">
    Set a new password for <strong>{{ $email }}</strong>. Use at least 12 characters, with uppercase, lowercase, and numbers.
</p>

<form method="POST" action="{{ route('admin.password.reset.store') }}" autocomplete="off">
    @csrf
    <div class="form-group" aria-hidden="true" style="position: absolute; left: -9999px; height: 0; overflow: hidden;">
        <label for="website">Website</label>
        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="password">New Password</label>
        <input type="password" id="password" name="password" class="form-control" required autofocus autocomplete="new-password">
    </div>
    <div class="form-group">
        <label for="password_confirmation">Confirm New Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required autocomplete="new-password">
    </div>
    <button type="submit" class="btn btn-dark" style="width: 100%;">Save New Password</button>
</form>
@endsection

@section('footer')
    <a href="{{ route('admin.password.forgot') }}">Start over</a>
    <span aria-hidden="true"> · </span>
    <a href="{{ route('admin.login') }}">Back to login</a>
@endsection
