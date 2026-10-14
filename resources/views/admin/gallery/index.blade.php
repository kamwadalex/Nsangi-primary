@extends('layouts.admin')

@section('title', 'Gallery')

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">Gallery</h1>
    <a href="{{ route('admin.gallery.create') }}" class="btn btn-primary">Add Image</a>
</div>

@include('admin.updates.partials.tabs', ['active' => 'gallery'])

<div class="admin-card">
    <table class="admin-table">
        <thead><tr><th>Title</th><th>Caption</th><th>Status</th><th></th></tr></thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td>{{ $item->title ?? '—' }}</td>
                <td>{{ $item->caption ?? '—' }}</td>
                <td>{{ $item->is_published ? 'Published' : 'Draft' }}</td>
                <td>
                    <a href="{{ route('admin.gallery.edit', $item) }}">Edit</a>
                    <form action="{{ route('admin.gallery.destroy', $item) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete?')" style="background:none;border:none;cursor:pointer;color:var(--red);">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4">No gallery items yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $items->links() }}
</div>
@endsection
