@extends('layouts.admin')

@section('title', 'Updates')

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">Updates</h1>
    <p style="margin: 0.35rem 0 0; color: #666;">Manage everything shown on the public Updates section — news, events, gallery, and school programme.</p>
</div>

<div class="stat-grid" style="margin-bottom: 2rem;">
    <div class="stat-card">
        <div class="num">{{ $stats['posts'] }}</div>
        <div>School News</div>
        <div style="margin-top: 0.35rem; font-size: 0.85rem; color: #666;">{{ $stats['published_posts'] }} published</div>
    </div>
    <div class="stat-card">
        <div class="num">{{ $stats['events'] }}</div>
        <div>School Events</div>
        <div style="margin-top: 0.35rem; font-size: 0.85rem; color: #666;">{{ $stats['published_events'] }} published</div>
    </div>
    <div class="stat-card">
        <div class="num">{{ $stats['gallery'] }}</div>
        <div>Gallery Items</div>
        <div style="margin-top: 0.35rem; font-size: 0.85rem; color: #666;">{{ $stats['published_gallery'] }} published</div>
    </div>
    <div class="stat-card">
        <div class="num">{{ $stats['programme'] }}</div>
        <div>Programme Items</div>
        <div style="margin-top: 0.35rem; font-size: 0.85rem; color: #666;">{{ $stats['published_programme'] }} published</div>
    </div>
</div>

@include('admin.updates.partials.tabs', ['active' => 'overview'])

<div class="admin-card" style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap; margin-bottom: 1rem;">
        <h2 style="margin: 0; font-size: 1.1rem;">Recent School News</h2>
        <span>
            <a href="{{ route('admin.updates.news.index') }}">View all</a>
            &nbsp;|&nbsp;
            <a href="{{ route('admin.posts.create') }}">Add news</a>
        </span>
    </div>
    <table class="admin-table">
        <thead><tr><th>Title</th><th>Published</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @forelse($posts as $post)
            <tr>
                <td>{{ $post->title }}</td>
                <td>{{ $post->published_at?->format('M j, Y') ?? '—' }}</td>
                <td>{{ $post->is_published ? 'Published' : 'Draft' }}</td>
                <td><a href="{{ route('admin.posts.edit', $post) }}">Edit</a></td>
            </tr>
            @empty
            <tr><td colspan="4">No news posts yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="admin-card" style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap; margin-bottom: 1rem;">
        <h2 style="margin: 0; font-size: 1.1rem;">Upcoming Events</h2>
        <span>
            <a href="{{ route('admin.updates.events.index') }}">View all</a>
            &nbsp;|&nbsp;
            <a href="{{ route('admin.events.create') }}">Add event</a>
        </span>
    </div>
    <table class="admin-table">
        <thead><tr><th>Title</th><th>Date</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @forelse($events as $event)
            <tr>
                <td>{{ $event->title }}</td>
                <td>{{ $event->starts_at->format('M j, Y') }}</td>
                <td>{{ $event->is_published ? 'Published' : 'Draft' }}</td>
                <td><a href="{{ route('admin.events.edit', $event) }}">Edit</a></td>
            </tr>
            @empty
            <tr><td colspan="4">No events yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="admin-card" style="margin-bottom: 2rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap; margin-bottom: 1rem;">
        <h2 style="margin: 0; font-size: 1.1rem;">Gallery</h2>
        <span>
            <a href="{{ route('admin.updates.gallery.index') }}">View all</a>
            &nbsp;|&nbsp;
            <a href="{{ route('admin.gallery.create') }}">Add image</a>
        </span>
    </div>
    <table class="admin-table">
        <thead><tr><th>Title</th><th>Caption</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @forelse($galleryItems as $item)
            <tr>
                <td>{{ $item->title ?? '—' }}</td>
                <td>{{ Str::limit($item->caption ?? '—', 60) }}</td>
                <td>{{ $item->is_published ? 'Published' : 'Draft' }}</td>
                <td><a href="{{ route('admin.gallery.edit', $item) }}">Edit</a></td>
            </tr>
            @empty
            <tr><td colspan="4">No gallery items yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="admin-card">
    <div style="display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap; margin-bottom: 1rem;">
        <h2 style="margin: 0; font-size: 1.1rem;">School Programme Calendar</h2>
        <span>
            <a href="{{ route('admin.updates.programme.index') }}">Manage calendar</a>
            &nbsp;|&nbsp;
            <a href="{{ route('admin.updates.programme.create') }}">Add entry</a>
        </span>
    </div>
    <table class="admin-table">
        <thead><tr><th>Date</th><th>Time</th><th>Title</th><th>Category</th><th></th></tr></thead>
        <tbody>
            @forelse($programmeEntries as $entry)
            <tr>
                <td>{{ $entry->starts_at->format('M j, Y') }}</td>
                <td>{{ $entry->starts_at->format('g:i A') }}</td>
                <td>{{ $entry->title }}</td>
                <td>{{ $entry->category }}</td>
                <td><a href="{{ route('admin.updates.programme.edit', $entry) }}">Edit</a></td>
            </tr>
            @empty
            <tr><td colspan="5">No programme entries yet. <a href="{{ route('admin.updates.programme.create') }}">Add one</a></td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
