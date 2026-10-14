@extends('admin.auth.partials.card')

@section('title', 'Forgot Password')
@section('heading', 'Forgot Password')

@section('content')
<p style="color: var(--gray); font-size: 0.9rem; margin-top: 0;">
    Enter the email address linked to your admin account.
</p>

<form method="POST" action="{{ route('admin.password.email') }}" autocomplete="off">
    @csrf
    <div class="form-group" aria-hidden="true" style="position: absolute; left: -9999px; height: 0; overflow: hidden;">
        <label for="website">Website</label>
        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus autocomplete="username">
    </div>
    <button type="submit" class="btn btn-dark" style="width: 100%;">Continue</button>
</form>
@endsection

@section('footer')
    <a href="{{ route('admin.login') }}">Back to login</a>
@endsection
