<article class="sensitive-info__card">
    <div class="sensitive-info__card-body">
        <h3 class="sensitive-info__card-title">{{ $document->title }}</h3>
        @if($document->description)
            <p class="sensitive-info__card-desc">{{ $document->description }}</p>
        @endif
    </div>

    @if($document->file)
        <div class="sensitive-info__file">
            <div class="sensitive-info__file-meta">
                <span class="sensitive-info__file-icon" aria-hidden="true">{{ $document->fileExtension() ?: 'FILE' }}</span>
                <div>
                    <p class="sensitive-info__file-name">{{ $document->original_filename ?: basename($document->file) }}</p>
                    @if($document->formattedFileSize())
                        <p class="sensitive-info__file-size">{{ $document->formattedFileSize() }}</p>
                    @endif
                </div>
            </div>
            <a href="{{ route('academics.sensitive-information.download', $document) }}" class="btn btn-primary sensitive-info__download">
                Download file
            </a>
        </div>
    @endif
</article>
