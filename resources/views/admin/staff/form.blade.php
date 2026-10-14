@extends('layouts.admin')

@php
    $category = $category ?? $member->category ?? 'administration';
    $categoryLabel = $categories[$category] ?? 'Staff';
@endphp

@section('title', ($member->exists ? 'Edit' : 'Add') . ' ' . $categoryLabel)

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">{{ $member->exists ? 'Edit' : 'Add' }} {{ $categoryLabel }}</h1>
</div>

<div class="admin-card">
    <form action="{{ $member->exists ? route('admin.staff.update', $member) : route('admin.staff.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($member->exists) @method('PUT') @endif

        <input type="hidden" name="category" value="{{ $category }}">

        <div class="form-group">
            <label>Category</label>
            <p style="margin: 0; font-weight: 600;">{{ $categoryLabel }}</p>
        </div>

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $member->name) }}" required>
        </div>

        @if($category === 'administration')
            <div class="form-group">
                <label for="position">Position</label>
                <input type="text" id="position" name="position" class="form-control" value="{{ old('position', $member->position) }}" required placeholder="e.g. Head Teacher, Deputy Admin">
            </div>

            <div class="form-group">
                <label for="bio">Bio / Description</label>
                <textarea id="bio" name="bio" class="form-control" placeholder="Short profile shown on the administration cards.">{{ old('bio', \App\Support\PlainTextContent::toPlain($member->bio)) }}</textarea>
                @include('admin.partials.plain-text-hint')
            </div>

            <div class="form-group">
                <label for="image">Photo</label>
                @include('admin.partials.image-preview', [
                    'current' => $member->image,
                    'input' => 'image',
                    'alt' => 'Current photo',
                    'maxHeight' => 120,
                ])
                <input type="file" id="image" name="image" class="form-control" accept="image/*">
                <small style="color: var(--gray);">Photo is displayed on the public Administration staff cards.</small>
            </div>
        @elseif($category === 'teaching')
            <div class="form-group">
                <label for="subjects_taught">Subjects Taught</label>
                <input type="text" id="subjects_taught" name="subjects_taught" class="form-control" value="{{ old('subjects_taught', $member->subjects_taught) }}" required placeholder="e.g. Mathematics, Physics">
                <small style="color: var(--gray);">Shown in the teaching staff table on the public site.</small>
            </div>
        @else
            <div class="form-group">
                <label for="position">Position</label>
                <input type="text" id="position" name="position" class="form-control" value="{{ old('position', $member->position) }}" required placeholder="e.g. School Bursar, School Secretary">
                <small style="color: var(--gray);">Shown in the non-teaching staff table on the public site.</small>
            </div>
        @endif

        <div class="form-group">
            <label for="sort_order">Sort Order</label>
            <input type="number" id="sort_order" name="sort_order" class="form-control" value="{{ old('sort_order', $member->sort_order ?? 0) }}" min="0">
        </div>

        <div class="form-group">
            <label><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $member->is_published ?? true))> Published</label>
        </div>

        <button type="submit" class="btn btn-dark">Save</button>
        <a href="{{ route('admin.staff.index') }}">Cancel</a>
    </form>
</div>
@endsection
