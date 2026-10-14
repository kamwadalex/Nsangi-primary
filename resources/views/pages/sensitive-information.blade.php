@extends('layouts.app')

@section('title', 'School Documents — ' . ($school['school_name'] ?? "Nsangi Parents' Primary School"))

@section('content')
@include('partials.page-hero', ['title' => 'School Documents'])

<section class="page-content">
    <div class="container">
        @if($page?->content)
            <div class="prose sensitive-info__intro">
                <x-plain-text :text="$page->content" />
            </div>
        @endif

        @forelse($sections as $section)
        <section class="sensitive-info__section">
            <h2 class="sensitive-info__heading">{{ $section->name }}</h2>
            <div class="sensitive-info__list">
                @foreach($section->publishedDocuments as $document)
                    @include('partials.sensitive-document-card', ['document' => $document])
                @endforeach
            </div>
        </section>
        @empty
            <p class="empty-state">School documents will be added here when they are ready to share.</p>
        @endforelse
    </div>
</section>
@endsection
