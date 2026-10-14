@extends('layouts.admin')

@section('title', ($document->exists ? 'Edit' : 'Upload') . ' Document')

@section('content')
<div class="admin-header">
    <h1 style="margin: 0;">{{ $document->exists ? 'Edit Document' : 'Upload Document' }}</h1>
</div>

<div class="admin-card">
    <form action="{{ $document->exists ? route('admin.sensitive-documents.update', $document) : route('admin.sensitive-documents.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($document->exists) @method('PUT') @endif

        <div class="form-group">
            <label for="sensitive_section_id">Section</label>
            <select id="sensitive_section_id" name="sensitive_section_id" class="form-control" required>
                <option value="">Select section</option>
                @foreach($sections as $section)
                    <option value="{{ $section->id }}" @selected(old('sensitive_section_id', $document->sensitive_section_id ?? $selectedSection?->id) == $section->id)>
                        {{ $section->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $document->title) }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" rows="4">{{ old('description', \App\Support\PlainTextContent::toPlain($document->description)) }}</textarea>
            @include('admin.partials.plain-text-hint')
        </div>

        <div class="form-group">
            <label for="file">File {{ $document->exists ? '(optional — leave blank to keep current file)' : '' }}</label>
            @if($document->file)
                <div class="sensitive-info__file sensitive-info__file--admin">
                    <div class="sensitive-info__file-meta">
                        <span class="sensitive-info__file-icon" aria-hidden="true">{{ $document->fileExtension() ?: 'FILE' }}</span>
                        <div>
                            <p class="sensitive-info__file-name">{{ $document->original_filename ?: basename($document->file) }}</p>
                            @if($document->formattedFileSize())
                                <p class="sensitive-info__file-size">{{ $document->formattedFileSize() }}</p>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('academics.sensitive-information.download', $document) }}" class="btn btn-outline" target="_blank" rel="noopener">View / Download</a>
                </div>
            @endif
            <input type="file" id="file" name="file" class="form-control" @if(!$document->exists) required @endif accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.zip,.rar,.jpg,.jpeg,.png">
            <small style="color: var(--gray);">PDF, Word, PowerPoint, Excel, images, text, or ZIP files (max 50MB).</small>
        </div>

        <div class="form-group">
            <label for="sort_order">Sort Order</label>
            <input type="number" id="sort_order" name="sort_order" class="form-control" value="{{ old('sort_order', $document->sort_order ?? 0) }}" min="0">
        </div>

        <div class="form-group">
            <label><input type="checkbox" name="is_published" value="1" @checked(old('is_published', $document->is_published ?? true))> Published</label>
        </div>

        <button type="submit" class="btn btn-dark">Save</button>
        <a href="{{ route('admin.sensitive-documents.index') }}">Cancel</a>
    </form>
</div>
@endsection
