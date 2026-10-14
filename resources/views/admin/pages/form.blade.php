@extends('layouts.admin')

@section('title', $page->exists ? 'Edit Page' : 'Create Page')

@section('content')
<div class="admin-header"><h1 style="margin: 0;">{{ $page->exists ? 'Edit Page' : 'Create Page' }}</h1></div>
<div class="admin-card">
    <form action="{{ $page->exists ? route('admin.pages.update', $page) : route('admin.pages.store') }}" method="POST">
        @csrf
        @if($page->exists) @method('PUT') @endif
        <div class="form-group"><label for="title">Title</label><input type="text" id="title" name="title" class="form-control" value="{{ old('title', $page->title) }}" required></div>
        <div class="form-group"><label for="slug">Slug</label><input type="text" id="slug" name="slug" class="form-control" value="{{ old('slug', $page->slug) }}" placeholder="auto-generated from title if empty"></div>
        <div class="form-group">
            <label for="section">Section</label>
            <select id="section" name="section" class="form-control">
                <option value="">— None —</option>
                <option value="about" @selected(old('section', $page->section) === 'about')>About</option>
                <option value="academics" @selected(old('section', $page->section) === 'academics')>Academics</option>
                <option value="students" @selected(old('section', $page->section) === 'students')>Students</option>
            </select>
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea id="content" name="content" class="form-control" rows="12">{{ old('content', \App\Support\PlainTextContent::toPlain($page->content)) }}</textarea>
            @include('admin.partials.plain-text-hint')
        </div>
        <div class="form-group"><label for="meta_description">Meta Description</label><input type="text" id="meta_description" name="meta_description" class="form-control" value="{{ old('meta_description', $page->meta_description) }}"></div>
        <div class="form-group"><label for="sort_order">Sort Order</label><input type="number" id="sort_order" name="sort_order" class="form-control" value="{{ old('sort_order', $page->sort_order ?? 0) }}"></div>
        <div class="form-group"><label><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $page->is_published ?? true))> Published</label></div>
        <button type="submit" class="btn btn-dark">Save</button>
        <a href="{{ route('admin.pages.index') }}">Cancel</a>
    </form>
</div>
@endsection
