@extends('layouts.admin')

@section('title', $item->exists ? 'Edit Gallery Item' : 'Add Gallery Item')

@section('content')
<div class="admin-header"><h1 style="margin: 0;">{{ $item->exists ? 'Edit Gallery Item' : 'Add Gallery Item' }}</h1></div>
<div class="admin-card">
    <form action="{{ $item->exists ? route('admin.gallery.update', $item) : route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($item->exists) @method('PUT') @endif
        <div class="form-group"><label for="title">Title</label><input type="text" id="title" name="title" class="form-control" value="{{ old('title', $item->title) }}"></div>
        <div class="form-group">
            <label for="image">Image @unless($item->exists)(required)@endunless</label>
            @include('admin.partials.image-preview', [
                'current' => $item->image,
                'input' => 'image',
                'alt' => 'Current gallery image',
                'maxHeight' => 140,
            ])
            <input type="file" id="image" name="image" class="form-control" accept="image/*" @unless($item->exists) required @endunless>
        </div>
        <div class="form-group"><label for="caption">Caption</label><input type="text" id="caption" name="caption" class="form-control" value="{{ old('caption', $item->caption) }}"></div>
        <div class="form-group"><label for="sort_order">Sort Order</label><input type="number" id="sort_order" name="sort_order" class="form-control" value="{{ old('sort_order', $item->sort_order ?? 0) }}"></div>
        <div class="form-group"><label><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $item->is_published ?? true))> Published</label></div>
        <button type="submit" class="btn btn-dark">Save</button>
        <a href="{{ route('admin.gallery.index') }}">Cancel</a>
    </form>
</div>
@endsection
