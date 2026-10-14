@extends('layouts.admin')

@section('title', $post->exists ? 'Edit Post' : 'Create Post')

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">{{ $post->exists ? 'Edit Post' : 'Create Post' }}</h1>
</div>

<div class="admin-card">
    <form action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($post->exists) @method('PUT') @endif

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $post->title) }}" required>
        </div>
        <div class="form-group">
            <label for="excerpt">Excerpt</label>
            <textarea id="excerpt" name="excerpt" class="form-control">{{ old('excerpt', \App\Support\PlainTextContent::toPlain($post->excerpt)) }}</textarea>
            @include('admin.partials.plain-text-hint')
        </div>
        <div class="form-group">
            <label for="content">Content</label>
            <textarea id="content" name="content" class="form-control" rows="10">{{ old('content', \App\Support\PlainTextContent::toPlain($post->content)) }}</textarea>
            @include('admin.partials.plain-text-hint')
        </div>
        <div class="form-group">
            <label for="image">Image</label>
            @include('admin.partials.image-preview', [
                'current' => $post->image,
                'input' => 'image',
                'alt' => 'Current post image',
                'maxHeight' => 140,
            ])
            <input type="file" id="image" name="image" class="form-control" accept="image/*">
        </div>
        <div class="form-group">
            <label for="published_at">Published At</label>
            <input type="datetime-local" id="published_at" name="published_at" class="form-control" value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}">
        </div>
        <div class="form-group">
            <label><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $post->is_published ?? true))> Published</label>
        </div>
        <button type="submit" class="btn btn-dark">Save</button>
        <a href="{{ route('admin.posts.index') }}">Cancel</a>
    </form>
</div>
@endsection
