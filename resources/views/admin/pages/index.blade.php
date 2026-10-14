@extends('layouts.admin')

@section('title', 'Pages')

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">Pages</h1>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">Add Page</a>
</div>
<div class="admin-card">
    <table class="admin-table">
        <thead><tr><th>Title</th><th>Section</th><th>Slug</th><th></th></tr></thead>
        <tbody>
            @forelse($pages as $page)
            <tr>
                <td>{{ $page->title }}</td>
                <td>{{ $page->section }}</td>
                <td>{{ $page->slug }}</td>
                <td>
                    <a href="{{ route('admin.pages.edit', $page) }}">Edit</a>
                    <form action="{{ route('admin.pages.destroy', $page) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete?')" style="background:none;border:none;cursor:pointer;color:var(--red);">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4">No pages yet.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $pages->links() }}
</div>
@endsection
