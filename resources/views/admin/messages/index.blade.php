@extends('layouts.admin')

@section('title', 'Messages')

@section('content')
<div class="admin-header"><h1 style="margin: 0;">Contact Messages</h1></div>
<div class="admin-card">
    <table class="admin-table">
        <thead><tr><th>From</th><th>Subject</th><th>Date</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @forelse($messages as $message)
            <tr>
                <td>{{ $message->name }}</td>
                <td>{{ $message->subject ?? '—' }}</td>
                <td>{{ $message->created_at->format('M j, Y g:i A') }}</td>
                <td>{{ $message->is_read ? 'Read' : 'Unread' }}</td>
                <td><a href="{{ route('admin.messages.show', $message) }}">View</a></td>
            </tr>
            @empty
            <tr><td colspan="5">No messages yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $messages->links() }}
</div>
@endsection
