@extends('layouts.admin')

@section('title', 'Sensitive Information Sections')

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">Sections</h1>
    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <a href="{{ route('admin.sensitive-documents.index') }}" class="btn btn-outline">Back to Documents</a>
        <a href="{{ route('admin.sensitive-sections.create') }}" class="btn btn-primary">Add Section</a>
    </div>
</div>

<p style="color: var(--gray); font-size: 0.9rem; margin-bottom: 1.25rem;">Create sections such as Holiday Work, School Circular, or Notes. Each section appears on the public Sensitive Information page when it has published documents.</p>

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Documents</th>
                <th>Order</th>
                <th>Published</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($sections as $section)
            <tr>
                <td>{{ $section->name }}</td>
                <td>{{ $section->documents_count }}</td>
                <td>{{ $section->sort_order }}</td>
                <td>{{ $section->is_published ? 'Yes' : 'No' }}</td>
                <td>
                    <a href="{{ route('admin.sensitive-documents.create', ['section' => $section->id]) }}">Add document</a>
                    |
                    <a href="{{ route('admin.sensitive-sections.edit', $section) }}">Edit</a>
                    <form action="{{ route('admin.sensitive-sections.destroy', $section) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this section and all its documents?')" style="background:none;border:none;cursor:pointer;color:var(--red);">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5">No sections yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
