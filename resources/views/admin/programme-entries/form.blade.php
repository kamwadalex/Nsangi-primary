@extends('layouts.admin')

@section('title', ($entry->exists ? 'Edit' : 'Add') . ' Programme Entry')

@section('content')
<div class="admin-header"><h1 style="margin: 0;">{{ $entry->exists ? 'Edit' : 'Add' }} Programme Entry</h1></div>

@include('admin.updates.partials.tabs', ['active' => 'programme'])

<div class="admin-card">
    <form action="{{ $entry->exists ? route('admin.updates.programme.update', $entry) : route('admin.updates.programme.store') }}" method="POST">
        @csrf
        @if($entry->exists) @method('PUT') @endif
        <input type="hidden" name="return_month" value="{{ $entry->starts_at?->month ?? now()->month }}">
        <input type="hidden" name="return_year" value="{{ $entry->starts_at?->year ?? now()->year }}">

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $entry->title) }}" required placeholder="e.g. Morning Assembly, P.E. Lesson">
        </div>

        <div class="form-grid form-grid--2">
            <div class="form-group">
                <label for="event_date">Date</label>
                <input type="date" id="event_date" name="event_date" class="form-control" value="{{ old('event_date', $entry->starts_at?->format('Y-m-d')) }}" required>
            </div>
            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" id="category" name="category" class="form-control" value="{{ old('category', $entry->category ?? 'General') }}" required placeholder="General">
            </div>
        </div>

        <div class="form-grid form-grid--2">
            <div class="form-group">
                <label for="start_time">Start Time</label>
                <input type="time" id="start_time" name="start_time" class="form-control" value="{{ old('start_time', $entry->starts_at?->format('H:i') ?? '08:00') }}" required>
            </div>
            <div class="form-group">
                <label for="end_time">End Time (optional)</label>
                <input type="time" id="end_time" name="end_time" class="form-control" value="{{ old('end_time', $entry->ends_at?->format('H:i')) }}">
            </div>
        </div>

        <div class="form-group">
            <label for="description">Description (optional)</label>
            <textarea id="description" name="description" class="form-control" rows="4">{{ old('description', \App\Support\PlainTextContent::toPlain($entry->description)) }}</textarea>
            @include('admin.partials.plain-text-hint')
        </div>

        <div class="form-group">
            <label><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $entry->is_published ?? true))> Published</label>
        </div>

        <button type="submit" class="btn btn-primary">Save Entry</button>
        <a href="{{ route('admin.updates.programme.index', ['month' => $entry->starts_at?->month ?? now()->month, 'year' => $entry->starts_at?->year ?? now()->year]) }}" class="btn btn-outline" style="margin-left: 0.5rem;">Cancel</a>
    </form>
</div>
@endsection
