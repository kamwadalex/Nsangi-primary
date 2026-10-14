@extends('admin.auth.partials.card')

@section('title', 'Master Reset Password')
@section('heading', 'Master Reset Password')

@section('content')
<p style="color: var(--gray); font-size: 0.9rem; margin-top: 0;">
    Account found for <strong>{{ $email }}</strong>. Enter the master reset password to continue. This password is set by the developer and is not your old account password.
</p>

<form method="POST" action="{{ route('admin.password.master.submit') }}" autocomplete="off">
    @csrf
    <div class="form-group" aria-hidden="true" style="position: absolute; left: -9999px; height: 0; overflow: hidden;">
        <label for="website">Website</label>
        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="master_password">Master Reset Password</label>
        <input
            type="password"
            id="master_password"
            name="master_password"
            class="form-control"
            required
            autofocus
            maxlength="255"
            autocomplete="off"
        >
    </div>
    <button type="submit" class="btn btn-dark" style="width: 100%;">Continue</button>
</form>
@endsection

@section('footer')
    <a href="{{ route('admin.password.forgot') }}">Start over</a>
    <span aria-hidden="true"> · </span>
    <a href="{{ route('admin.login') }}">Back to login</a>
@endsection
