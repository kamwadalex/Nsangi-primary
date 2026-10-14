@extends('admin.auth.partials.card')

@section('title', 'Admin Login')
@section('heading', 'Admin Login')

@section('content')
<form method="POST" action="{{ route('admin.login') }}" autocomplete="off">
    @csrf
    <div class="form-group" aria-hidden="true" style="position: absolute; left: -9999px; height: 0; overflow: hidden;">
        <label for="website">Website</label>
        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus autocomplete="username">
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" class="form-control" required autocomplete="current-password">
    </div>
    <div class="form-group">
        <label><input type="checkbox" name="remember"> Remember me</label>
    </div>
    <button type="submit" class="btn btn-dark" style="width: 100%;">Login</button>
</form>
@endsection

@section('footer')
    <a href="{{ route('admin.password.forgot') }}">Forgot password?</a>
@endsection
