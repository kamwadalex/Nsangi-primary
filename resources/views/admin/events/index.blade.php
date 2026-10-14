@extends('layouts.admin')

@section('title', 'School Events')

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">School Events</h1>
    <a href="{{ route('admin.events.create') }}" class="btn btn-primary">Add Event</a>
</div>

@include('admin.updates.partials.tabs', ['active' => 'events'])

<div class="admin-card">
    <table class="admin-table">
        <thead><tr><th>Title</th><th>Date</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @forelse($events as $event)
            <tr>
                <td>{{ $event->title }}</td>
                <td>{{ $event->starts_at->format('M j, Y') }}</td>
                <td>{{ $event->is_published ? 'Published' : 'Draft' }}</td>
                <td>
                    <a href="{{ route('admin.events.edit', $event) }}">Edit</a>
                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete?')" style="background:none;border:none;cursor:pointer;color:var(--red);">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4">No events yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $events->links() }}
</div>
@endsection
