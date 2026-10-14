@extends('admin.auth.partials.card')

@section('title', 'Change Password')
@section('heading', 'Set New Password')

@section('content')
<p style="color: var(--gray); font-size: 0.9rem; margin-top: 0;">
    Choose a strong password with at least 12 characters, including uppercase, lowercase, and numbers.
</p>

<form method="POST" action="{{ route('admin.password.update') }}" autocomplete="off">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="password">New Password</label>
        <input type="password" id="password" name="password" class="form-control" required autofocus autocomplete="new-password">
    </div>
    <div class="form-group">
        <label for="password_confirmation">Confirm New Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required autocomplete="new-password">
    </div>
    <button type="submit" class="btn btn-dark" style="width: 100%;">Update Password</button>
</form>
@endsection

@section('footer')
    <form method="POST" action="{{ route('admin.logout') }}" style="display: inline;">
        @csrf
        <button type="submit" class="admin-auth-link-button">Logout</button>
    </form>
@endsection
