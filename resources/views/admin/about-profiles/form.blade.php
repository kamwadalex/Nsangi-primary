@extends('layouts.admin')

@php
    $category = $category ?? $profile->category ?? 'head-teachers';
    $categoryLabel = $categories[$category] ?? 'Profile';
@endphp

@section('title', ($profile->exists ? 'Edit' : 'Add') . ' ' . $categoryLabel)

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">{{ $profile->exists ? 'Edit' : 'Add' }} {{ $categoryLabel }}</h1>
</div>

<div class="admin-card">
    <form action="{{ $profile->exists ? route('admin.about-profiles.update', $profile) : route('admin.about-profiles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($profile->exists) @method('PUT') @endif

        <input type="hidden" name="category" value="{{ $category }}">

        <div class="form-group">
            <label>Section</label>
            <p style="margin: 0; font-weight: 600;">{{ $categoryLabel }}</p>
        </div>

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $profile->name) }}" required>
        </div>

        <div class="form-group">
            <label for="position">Position</label>
            <input
                type="text"
                id="position"
                name="position"
                class="form-control"
                value="{{ old('position', $profile->position) }}"
                required
                placeholder="@switch($category)
                    @case('head-teachers') e.g. Current Head Teacher, Former Head Teacher @break
                    @case('board-of-governors') e.g. Chairperson, Board Member @break
                    @case('pta') e.g. PTA Chairperson, PTA Secretary @break
                    @case('school-founders') e.g. Founding Parish Priest, Community Founder @break
                    @default Position @break
                @endswitch"
            >
        </div>

        <div class="form-group">
            <label for="bio">Description</label>
            <textarea id="bio" name="bio" class="form-control" rows="5" placeholder="Short profile shown on the About page.">{{ old('bio', \App\Support\PlainTextContent::toPlain($profile->bio)) }}</textarea>
            @include('admin.partials.plain-text-hint')
            @if($category === 'school-founders')
                <small style="color: var(--gray);">Share the founder's role in establishing the school.</small>
            @elseif($category === 'head-teachers')
                <small style="color: var(--gray);">Brief leadership background shown on the Head Teachers section.</small>
            @endif
        </div>

        @if(in_array($category, ['head-teachers', 'board-of-governors'], true))
            <div class="form-group">
                <label for="image">Photo</label>
                @include('admin.partials.image-preview', [
                    'current' => $profile->image,
                    'input' => 'image',
                    'alt' => 'Current photo',
                    'maxHeight' => 120,
                ])
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                <small style="color: var(--gray);">Photo is displayed on the public About page profile cards.</small>
            </div>
        @else
            <div class="form-group">
                <label for="image">Photo <span style="font-weight: normal; color: var(--gray);">(optional)</span></label>
                @include('admin.partials.image-preview', [
                    'current' => $profile->image,
                    'input' => 'image',
                    'alt' => 'Current photo',
                    'maxHeight' => 120,
                ])
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                <small style="color: var(--gray);">Optional photo for the About page profile card.</small>
            </div>
        @endif

        <div class="form-group">
            <label for="sort_order">Sort Order</label>
            <input type="number" id="sort_order" name="sort_order" class="form-control" value="{{ old('sort_order', $profile->sort_order ?? 0) }}" min="0">
        </div>

        <div class="form-group">
            <label><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $profile->is_published ?? true))> Published</label>
        </div>

        <button type="submit" class="btn btn-dark">Save</button>
        <a href="{{ route('admin.about-profiles.index') }}">Cancel</a>
    </form>
</div>
@endsection
