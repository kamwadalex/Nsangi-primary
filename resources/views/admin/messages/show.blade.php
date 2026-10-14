@extends('layouts.admin')

@section('title', 'View Message')

@section('content')
<div class="admin-header"><h1 style="margin: 0;">Message from {{ $message->name }}</h1></div>
<div class="admin-card">
    <p><strong>Email:</strong> {{ $message->email }}</p>
    @if($message->phone)<p><strong>Phone:</strong> {{ $message->phone }}</p>@endif
    @if($message->subject)<p><strong>Subject:</strong> {{ $message->subject }}</p>@endif
    <p><strong>Received:</strong> {{ $message->created_at->format('F j, Y g:i A') }}</p>
    <hr>
    <p>{{ $message->message }}</p>
    <p style="margin-top: 1.5rem;">
        <a href="{{ route('admin.messages.index') }}">&larr; Back</a>
        <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" style="display:inline;">
            @csrf @method('DELETE')
            <button type="submit" onclick="return confirm('Delete?')" class="btn btn-outline" style="margin-left: 1rem;">Delete</button>
        </form>
    </p>
</div>
@endsection
