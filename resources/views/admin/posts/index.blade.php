@extends('layouts.admin')

@section('title', 'School News')

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">School News</h1>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">Add Post</a>
</div>

@include('admin.updates.partials.tabs', ['active' => 'news'])

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr><th>Title</th><th>Published</th><th>Status</th><th></th></tr>
        </thead>
        <tbody>
            @forelse($posts as $post)
            <tr>
                <td>{{ $post->title }}</td>
                <td>{{ $post->published_at?->format('M j, Y') ?? '—' }}</td>
                <td>{{ $post->is_published ? 'Published' : 'Draft' }}</td>
                <td>
                    <a href="{{ route('admin.posts.edit', $post) }}">Edit</a>
                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this post?')" style="background:none;border:none;cursor:pointer;color:var(--red);">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4">No posts yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $posts->links() }}
</div>
@endsection
