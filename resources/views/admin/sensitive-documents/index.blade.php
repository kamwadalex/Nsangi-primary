@extends('layouts.admin')

@section('title', 'Sensitive Information')

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">Sensitive Information</h1>
    <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
        <a href="{{ route('admin.sensitive-sections.index') }}" class="btn btn-outline">Manage Sections</a>
        <a href="{{ route('admin.sensitive-documents.create') }}" class="btn btn-primary">Add Document</a>
    </div>
</div>

<p style="color: var(--gray); font-size: 0.9rem; margin-bottom: 1.25rem;">Upload files for parents and students. Files up to 50MB are supported. Edit the page introduction under <a href="{{ route('admin.pages.index') }}">Pages</a> (slug: sensitive-information).</p>

@foreach($sections as $section)
    <div class="admin-card" style="margin-bottom: 1.5rem;">
        <div class="admin-header" style="margin-bottom: 1rem;">
            <h2 style="margin: 0; font-size: 1.1rem;">{{ $section->name }}</h2>
            <a href="{{ route('admin.sensitive-documents.create', ['section' => $section->id]) }}" class="btn btn-primary">Add to {{ $section->name }}</a>
        </div>

        <table class="admin-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>File</th>
                    <th>Size</th>
                    <th>Order</th>
                    <th>Published</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($section->documents as $document)
                <tr>
                    <td>{{ $document->title }}</td>
                    <td>
                        @if($document->file)
                            <a href="{{ route('academics.sensitive-information.download', $document) }}" target="_blank" rel="noopener">
                                {{ $document->original_filename ?: basename($document->file) }}
                            </a>
                        @else
                            —
                        @endif
                    </td>
                    <td>{{ $document->formattedFileSize() ?: '—' }}</td>
                    <td>{{ $document->sort_order }}</td>
                    <td>{{ $document->is_published ? 'Yes' : 'No' }}</td>
                    <td>
                        <a href="{{ route('admin.sensitive-documents.edit', $document) }}">Edit</a>
                        <form action="{{ route('admin.sensitive-documents.destroy', $document) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Delete?')" style="background:none;border:none;cursor:pointer;color:var(--red);">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6">No documents in this section yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endforeach
@endsection
