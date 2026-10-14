@extends('layouts.admin')

@section('title', 'Settings')

@section('content')
<div class="admin-header"><h1 style="margin: 0;">School Settings</h1></div>

<div class="admin-card">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <h2 style="margin-top: 0; font-size: 1.1rem;">Site Images</h2>
        <p style="color: var(--gray); font-size: 0.9rem; margin-bottom: 1.25rem;">Upload images to replace the grey placeholders on the public website.</p>
        <div class="grid-2" style="margin-bottom: 2rem;">
            <div class="form-group">
                <label for="logo">School Badge / Logo (header)</label>
                @include('admin.partials.image-preview', [
                    'current' => $settings['logo'] ?? null,
                    'input' => 'logo',
                    'alt' => 'Current logo',
                    'maxHeight' => 72,
                ])
                <input type="file" id="logo" name="logo" class="form-control" accept="image/*">
            </div>
            <div class="form-group">
                <label for="hero_image">Hero Welcome Background</label>
                @include('admin.partials.image-preview', [
                    'current' => $settings['hero_image'] ?? null,
                    'input' => 'hero_image',
                    'alt' => 'Current hero',
                    'maxHeight' => 100,
                ])
                <input type="file" id="hero_image" name="hero_image" class="form-control" accept="image/*">
            </div>
            <div class="form-group">
                <label for="head_teacher_photo">Head Teacher Photo</label>
                @include('admin.partials.image-preview', [
                    'current' => $settings['head_teacher_photo'] ?? null,
                    'input' => 'head_teacher_photo',
                    'alt' => 'Head teacher',
                    'maxHeight' => 120,
                ])
                <input type="file" id="head_teacher_photo" name="head_teacher_photo" class="form-control" accept="image/*">
            </div>
            <div class="form-group">
                <label for="about_image">About / Campus Photo</label>
                @include('admin.partials.image-preview', [
                    'current' => $settings['about_image'] ?? null,
                    'input' => 'about_image',
                    'alt' => 'About',
                    'maxHeight' => 100,
                ])
                <input type="file" id="about_image" name="about_image" class="form-control" accept="image/*">
            </div>
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="page_banner">Default Page Banner (inner pages)</label>
                @include('admin.partials.image-preview', [
                    'current' => $settings['page_banner'] ?? null,
                    'input' => 'page_banner',
                    'alt' => 'Page banner',
                    'maxHeight' => 100,
                ])
                <input type="file" id="page_banner" name="page_banner" class="form-control" accept="image/*">
            </div>
        </div>

        <h2 style="font-size: 1.1rem;">General Settings</h2>
        <div class="grid-2">
            <div class="form-group">
                <label for="school_name">School Name</label>
                <input type="text" id="school_name" name="school_name" class="form-control" value="{{ $settings['school_name'] ?? '' }}">
            </div>
            <div class="form-group">
                <label for="motto">Motto</label>
                <input type="text" id="motto" name="motto" class="form-control" value="{{ $settings['motto'] ?? '' }}">
            </div>
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="tagline">Tagline / Introduction</label>
                <textarea id="tagline" name="tagline" class="form-control">{{ \App\Support\PlainTextContent::toPlain($settings['tagline'] ?? '') }}</textarea>
                @include('admin.partials.plain-text-hint')
            </div>
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="school_story">School Story (Humble Beginning)</label>
                <textarea id="school_story" name="school_story" class="form-control" rows="10">{{ \App\Support\PlainTextContent::toPlain($settings['school_story'] ?? '') }}</textarea>
                @include('admin.partials.plain-text-hint')
            </div>
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="about_school_content">About the School (About Page)</label>
                <textarea id="about_school_content" name="about_school_content" class="form-control" rows="8">{{ \App\Support\PlainTextContent::toPlain($settings['about_school_content'] ?? '') }}</textarea>
                @include('admin.partials.plain-text-hint')
            </div>
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="school_anthem">School Anthem Lyrics</label>
                <textarea id="school_anthem" name="school_anthem" class="form-control" rows="8">{{ \App\Support\PlainTextContent::toPlain($settings['school_anthem'] ?? '') }}</textarea>
                @include('admin.partials.plain-text-hint')
            </div>
            <div class="form-group">
                <label for="phone">Phone 1</label>
                <input type="text" id="phone" name="phone" class="form-control" value="{{ $settings['phone'] ?? '' }}">
            </div>
            <div class="form-group">
                <label for="phone_2">Phone 2</label>
                <input type="text" id="phone_2" name="phone_2" class="form-control" value="{{ $settings['phone_2'] ?? '' }}">
            </div>
            <div class="form-group">
                <label for="phone_3">Phone 3</label>
                <input type="text" id="phone_3" name="phone_3" class="form-control" value="{{ $settings['phone_3'] ?? '' }}">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ $settings['email'] ?? '' }}">
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <input type="text" id="address" name="address" class="form-control" value="{{ $settings['address'] ?? '' }}">
            </div>
            <div class="form-group">
                <label for="levels_offered">Levels Offered</label>
                <input type="text" id="levels_offered" name="levels_offered" class="form-control" value="{{ $settings['levels_offered'] ?? '' }}">
            </div>
            <div class="form-group">
                <label for="admission_status">Admission Status</label>
                <input type="text" id="admission_status" name="admission_status" class="form-control" value="{{ $settings['admission_status'] ?? '' }}">
            </div>
            <div class="form-group">
                <label for="center_number">Center Number</label>
                <input type="text" id="center_number" name="center_number" class="form-control" value="{{ $settings['center_number'] ?? '' }}">
            </div>
            <div class="form-group">
                <label for="years_existence">Years of Existence</label>
                <input type="text" id="years_existence" name="years_existence" class="form-control" value="{{ $settings['years_existence'] ?? '' }}">
            </div>
            <div class="form-group">
                <label for="head_teacher_name">Head Teacher Name</label>
                <input type="text" id="head_teacher_name" name="head_teacher_name" class="form-control" value="{{ $settings['head_teacher_name'] ?? '' }}">
            </div>
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="head_teacher_message">Head Teacher Message</label>
                <textarea id="head_teacher_message" name="head_teacher_message" class="form-control" rows="6">{{ \App\Support\PlainTextContent::toPlain($settings['head_teacher_message'] ?? '') }}</textarea>
                @include('admin.partials.plain-text-hint')
            </div>
            <div class="form-group">
                <label for="mission">Mission</label>
                <textarea id="mission" name="mission" class="form-control">{{ \App\Support\PlainTextContent::toPlain($settings['mission'] ?? '') }}</textarea>
                @include('admin.partials.plain-text-hint')
            </div>
            <div class="form-group">
                <label for="mission_objectives">Mission Objectives</label>
                <textarea id="mission_objectives" name="mission_objectives" class="form-control" rows="6">{{ \App\Support\PlainTextContent::toPlain($settings['mission_objectives'] ?? '') }}</textarea>
                @include('admin.partials.plain-text-hint')
            </div>
            <div class="form-group">
                <label for="short_term_objectives">Short Term Objectives</label>
                <textarea id="short_term_objectives" name="short_term_objectives" class="form-control" rows="6">{{ \App\Support\PlainTextContent::toPlain($settings['short_term_objectives'] ?? '') }}</textarea>
                @include('admin.partials.plain-text-hint')
            </div>
            <div class="form-group">
                <label for="vision">Vision</label>
                <textarea id="vision" name="vision" class="form-control">{{ \App\Support\PlainTextContent::toPlain($settings['vision'] ?? '') }}</textarea>
                @include('admin.partials.plain-text-hint')
            </div>
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="core_values">Core Values</label>
                <input type="text" id="core_values" name="core_values" class="form-control" value="{{ $settings['core_values'] ?? '' }}">
            </div>
        </div>
        <button type="submit" class="btn btn-dark">Save Settings</button>
    </form>
</div>

<div class="admin-card" style="margin-top: 2rem;">
    <h2 style="margin-top: 0; font-size: 1.1rem;">Admin Account</h2>
    <p style="color: var(--gray); font-size: 0.9rem; margin-bottom: 1.25rem;">
        Update the username, login email, and password used to access this admin panel.
    </p>

    <form action="{{ route('admin.settings.account.update') }}" method="POST" autocomplete="off">
        @csrf
        @method('PUT')

        <div class="grid-2">
            <div class="form-group">
                <label for="admin_name">Username</label>
                <input
                    type="text"
                    id="admin_name"
                    name="name"
                    class="form-control @error('name') is-invalid @enderror"
                    value="{{ old('name', $user->name) }}"
                    required
                    autocomplete="username"
                >
                @error('name')
                    <p style="color: var(--red); font-size: 0.85rem; margin: 0.35rem 0 0;">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="admin_email">Login Email</label>
                <input
                    type="email"
                    id="admin_email"
                    name="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email', $user->email) }}"
                    required
                    autocomplete="email"
                >
                @error('email')
                    <p style="color: var(--red); font-size: 0.85rem; margin: 0.35rem 0 0;">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="current_password">Current Password</label>
                <input
                    type="password"
                    id="current_password"
                    name="current_password"
                    class="form-control @error('current_password') is-invalid @enderror"
                    autocomplete="current-password"
                >
                <p style="color: var(--gray); font-size: 0.85rem; margin: 0.35rem 0 0;">Required only when changing your password.</p>
                @error('current_password')
                    <p style="color: var(--red); font-size: 0.85rem; margin: 0.35rem 0 0;">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="admin_password">New Password</label>
                <input
                    type="password"
                    id="admin_password"
                    name="password"
                    class="form-control @error('password') is-invalid @enderror"
                    autocomplete="new-password"
                >
                @error('password')
                    <p style="color: var(--red); font-size: 0.85rem; margin: 0.35rem 0 0;">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="admin_password_confirmation">Confirm New Password</label>
                <input
                    type="password"
                    id="admin_password_confirmation"
                    name="password_confirmation"
                    class="form-control"
                    autocomplete="new-password"
                >
            </div>
        </div>

        <p style="color: var(--gray); font-size: 0.85rem; margin: 0 0 1rem;">
            Leave the new password fields blank to keep your current password. New passwords must be at least 12 characters with uppercase, lowercase, and numbers.
        </p>

        <button type="submit" class="btn btn-dark">Update Account</button>
    </form>
</div>
@endsection
