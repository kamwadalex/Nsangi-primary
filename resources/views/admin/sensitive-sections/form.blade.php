@extends('layouts.admin')

@section('title', ($section->exists ? 'Edit' : 'Add') . ' Section')

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">{{ $section->exists ? 'Edit Section' : 'Add Section' }}</h1>
</div>

<div class="admin-card">
    <form action="{{ $section->exists ? route('admin.sensitive-sections.update', $section) : route('admin.sensitive-sections.store') }}" method="POST">
        @csrf
        @if($section->exists) @method('PUT') @endif

        <div class="form-group">
            <label for="name">Section Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $section->name) }}" required placeholder="e.g. School Circular">
        </div>

        <div class="form-group">
            <label for="sort_order">Sort Order</label>
            <input type="number" id="sort_order" name="sort_order" class="form-control" value="{{ old('sort_order', $section->sort_order ?? 0) }}" min="0">
        </div>

        <div class="form-group">
            <label><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $section->is_published ?? true))> Published</label>
        </div>

        <button type="submit" class="btn btn-dark">Save</button>
        <a href="{{ route('admin.sensitive-sections.index') }}">Cancel</a>
    </form>
</div>
@endsection
