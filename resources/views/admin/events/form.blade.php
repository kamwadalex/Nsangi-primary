@extends('layouts.admin')

@section('title', $event->exists ? 'Edit Event' : 'Create Event')

@section('content')
<div class="admin-header"><h1 style="margin: 0;">{{ $event->exists ? 'Edit Event' : 'Create Event' }}</h1></div>
<div class="admin-card">
    <form action="{{ $event->exists ? route('admin.events.update', $event) : route('admin.events.store') }}" method="POST">
        @csrf
        @if($event->exists) @method('PUT') @endif
        <div class="form-group"><label for="title">Title</label><input type="text" id="title" name="title" class="form-control" value="{{ old('title', $event->title) }}" required></div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" rows="6">{{ old('description', \App\Support\PlainTextContent::toPlain($event->description)) }}</textarea>
            @include('admin.partials.plain-text-hint')
        </div>
        <div class="form-group"><label for="location">Location</label><input type="text" id="location" name="location" class="form-control" value="{{ old('location', $event->location) }}"></div>
        <div class="form-group"><label for="starts_at">Starts At</label><input type="datetime-local" id="starts_at" name="starts_at" class="form-control" value="{{ old('starts_at', $event->starts_at?->format('Y-m-d\TH:i')) }}" required></div>
        <div class="form-group"><label for="ends_at">Ends At</label><input type="datetime-local" id="ends_at" name="ends_at" class="form-control" value="{{ old('ends_at', $event->ends_at?->format('Y-m-d\TH:i')) }}"></div>
        <div class="form-group"><label for="category">Category</label><input type="text" id="category" name="category" class="form-control" value="{{ old('category', $event->category) }}"></div>
        <div class="form-group"><label><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $event->is_published ?? true))> Published</label></div>
        <button type="submit" class="btn btn-dark">Save</button>
        <a href="{{ route('admin.events.index') }}">Cancel</a>
    </form>
</div>
@endsection
